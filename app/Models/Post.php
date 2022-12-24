<?php

namespace App\Models;

use App\Models\Scopes\WithCountComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Post extends Model
{
    use HasFactory, SoftDeletes;
    public function community() {
        return $this->belongsTo(Community::class);
    }
    public function user() {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
    public function comments() {
        return $this->hasMany(Comment::class);
    }  
    public function likes() {
        return $this->hasMany(PostVote::class);
    }

    public function scopeLikesCount($query) {
        return $query->withCount([
            'likes as likes_count' => function ($q) { $q->where('vote', 1); },
            'likes as dislikes_count' => function ($q) { $q->where('vote', 0); },
        ]);
    }
    protected static function booted() {
        static::addGlobalScope(new WithCountComments);
   }
}
