<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ReplyResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            =>  $this->id,
            'user_id'       =>  $this->user_id,
            'description'   =>  $this->description,
            'time'          =>  $this->created_at->diffForHumans(),
            'file'          =>  $this->file ? '/storage/' . $this->file : null,
            'video'         =>  $this->original_name ? Storage::disk('public')->url('uploads/' . $this->user->id . '/' . 'videos/' . $this->id . '.mp4') : null,  
            'category'      =>  $this->category->name,
            'category_id'   =>  $this->category->id,
            'category_slug' =>  $this->category->slug,
            'avatar'        =>  $this->user->getProfilePhotoUrlAttribute(),
            'username'      =>  $this->user->username,
            'name'          =>  $this->user->name,
            'user'          =>  UserResource::make($this->whenLoaded('user')),
            'replycount'    =>  $this->replies->count(),
            'upvotes'       =>  $this->totalUpvotes(),
            'downvotes'     =>  $this->totalDownvotes(),
            'replies'       =>  ReplyResource::collection($this->whenLoaded('replies')),
            'has'           => [
                'delete'        =>  Auth::user() ? Auth::user()->can('delete-post', $this->resource) : null,
                'voted'         =>  Auth::user() ? Auth::user()->attachVoteStatus($this->resource) : null
            ]
        ];
    }
}
