<?php

namespace App\Models;

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
}
