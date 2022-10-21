<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class ReplyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'        =>  $this->id,
            'reply'     =>  $this->reply,
            'time'      =>  $this->created_at->diffForHumans(),
            'username'  =>  $this->user->username,
            'avatar'    =>  $this->user->getProfilePhotoUrlAttribute(),
            'link'      =>  '@' . $this->user->username,
            'upvotes'       =>  $this->totalUpvotes(),
            'downvotes'     =>  $this->totalDownvotes(),
            'delete'    =>  Auth::user() ? Auth::user()->can('delete-reply', $this->resource) : null,
            'has'           => [
                'voted'     =>  Auth::user() ? Auth::user()->attachVoteStatus($this->resource) : null
            ]
        ];
    }
}
