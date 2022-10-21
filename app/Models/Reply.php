<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelVote\Traits\Votable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reply extends Model
{
    use HasFactory;
    use Votable;

    protected $with = ['user'];

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function post() 
    {
        return $this->belongsTo(Post::class, 'user_id');
    }
}
