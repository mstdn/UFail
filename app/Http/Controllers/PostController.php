<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\ReplyResource;
use App\Jobs\ConvertVideoForDownloading;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Feed/Index', [
            'posts'     =>  PostResource::collection(
                Post::with('user', 'category', 'replies')
                    ->withCount(['voters', 'upvoters', 'downvoters'])
                    ->when($request->input('search'), function ($query, $search) {
                        $query->where('description', 'like', "%{$search}%");
                    })
                    ->latest()
                    ->paginate(6)
                    ->withQueryString()
            ),
            'filters'   => $request->only(['search'])
        ]);
    }

    public function trending(Request $request)
    {
        return Inertia::render('Feed/Index', [
            'posts'     =>  PostResource::collection(
                Post::with('user', 'category', 'replies')
                    ->withCount(['voters', 'upvoters', 'downvoters'])
                    ->orderBy('upvoters_count', 'desc')
                    ->paginate(6)
            ),
            'filters'   => $request->only(['search'])
        ]);
    }

    public function store(Request $request)
    {
        $post = $request->validate([
            'description'   =>  'required|min:1|max:500',
            'category'      =>  ['required', Rule::exists('categories', 'id')],
            'file'          =>  ['nullable', 'mimes:jpg,jpeg,png,gif', 'max:500048'],
            'video'         =>  'nullable|file|mimetypes:video/x-ms-asf,video/x-flv,video/mp4,video/mpeg,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi|max:10240',
        ]);

        $post['user_id'] = auth()->id();

        if ($request->hasFile('file')) {
            $post['file'] = $request->file('file')->store('media/' . $request->user()->id . '/' . now()->format('Y') . '/' . now()->format('m'), 'public');

            $post = Post::create([
                'user_id'       =>  auth()->id(),
                'description'   =>  $request->description,
                'category_id'   =>  $request->category,
                'file'          =>  $request->file->store('photo/' . $request->user()->id . '/' . now()->format('Y') . '/' . now()->format('m'), 'public')
            ]);

            return back();
        }

        if ($request->hasFile('video')) {

            $post = Post::create([
                'user_id'       =>  auth()->id(),
                'description'   =>  $request->description,
                'category_id'   =>  $request->category,
                'disk'          =>  'public',
                'original_name' =>  $request->file('video')->getClientOriginalName(),
                'path'          =>  $request->file('video')->store('uploads' . $request['user_id'] . '/' . 'videos/', 'public'),
            ]);

            $this->dispatch(new ConvertVideoForDownloading($post));

            return back();
        }

        $post = Post::create([
            'user_id'       =>  auth()->id(),
            'category_id'   =>  $request->category,
            'description'   =>  $request->description,
        ]);

        return back();
    }

    public function upvote(Post $post)
    {
        $voted = Auth::user()->attachVoteStatus($post);

        if ($voted->has_upvoted === true) {
            Auth::user()->cancelVote($post);
        } else {
            Auth::user()->vote($post, 1);
        }
    }

    public function downvote(Post $post)
    {
        $voted = Auth::user()->attachVoteStatus($post);

        if ($voted->has_downvoted === true) {
            Auth::user()->cancelVote($post);
        } else {
            Auth::user()->vote($post, -1);
        }
    }

    public function show(Post $post)
    {
        return Inertia::render('Posts/Show', [
            'post'      =>  PostResource::make($post),
            'replies'   =>  $post->replies
        ]);
    }

    public function destroy(Post $post)
    {
        if (!Gate::allows('delete-post', $post)) {
            abort(403);
        }

        File::delete($post->path);
        File::delete('/uploads' . $post->user->id . '/videos/' . $post->id);

        /* $firstPath = $post->path;
        if(File::exists($firstPath)) {
            File::delete($firstPath);
        } */
        $secondPath = public_path('../storage/uploads' . $post->user->id . '/videos/' . $post->id);
        if(File::exists($secondPath)) {
            File::delete($secondPath);
        }
        // Storage::disk('public')->delete($path);
        // Storage::disk('public')->delete('/uploads' . $post->user->id . '/videos/' . $post->id);

        $post->delete();
        return redirect('/')->with('message', 'Post deleted successfully.');
    }
}
