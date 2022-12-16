<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    
    public function show($username) {
        $user = User::where('username', $username)->first();
        $posts = Post::where('author_id', $user->id)->withCount('comments')->get();
        $contentViews = DB::table('posts')->select(DB::raw("sum(number_visites) as contentView"))->where('author_id', $user->id)->pluck('contentView');
        return view('main.user', [
            'user' => $user,
            'posts' => $posts,
            'contentViews' => $contentViews[0]
        ]);
    }


}
