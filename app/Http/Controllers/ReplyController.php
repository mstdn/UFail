<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Notifications\RepliedPostNotification;

class ReplyController extends Controller
{
    public function store(Request $request, Post $post, Reply $reply) {
        
        $attributes = $request->validate([
            'reply' => 'required|max:500|min:1'
        ]);

        $attributes['post_id'] = $request['post_id'];
        $attributes['user_id'] = auth()->id();
        $post->replies()->create($attributes);
        $post->user->notify(new RepliedPostNotification(auth()->user(), $post, $reply));

        return back();
    }

    public function upvote(Reply $reply)
    {
        $voted = Auth::user()->attachVoteStatus($reply);

        if ($voted->has_upvoted === true) {
            Auth::user()->cancelVote($reply);
        } else {
            Auth::user()->vote($reply, 1);
        }
    }

    public function downvote(Reply $reply)
    {
        $voted = Auth::user()->attachVoteStatus($reply);

        if ($voted->has_downvoted === true) {
            Auth::user()->cancelVote($reply);
        } else {
            Auth::user()->vote($reply, -1);
        }
    }
   
    public function destroy(Reply $reply)
    {
        if (! Gate::allows('delete-reply', $reply)) {
            abort(403);
        }
        $reply->delete();
    
        return back();
    }
}
