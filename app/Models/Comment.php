<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;
    public function post() {
        return $this->belongsTo(Post::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function likes() {
        return $this->hasMany(CommentVote::class);
    }
    public function scopeLikesCount($query) {
        return $query->withCount([
            'likes as likes_count' => function ($q) { $q->where('vote', 1); },
            'likes as dislikes_count' => function ($q) { $q->where('vote', 0); },
        ]);
    }
    
}
