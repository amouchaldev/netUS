<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Community;
use App\Models\Post;
use App\Models\UserCommunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    public function index()
    {
        return view('main.communities', [
            'communities' => Community::withCount('users')->get()
        ]);
    }

    public function community($slug, $status = null)
    {

        // get all posts that belongs to specific community
        if (!$status) {
            $community = Community::where('slug', $slug)->first();
            $posts = Post::where('community_id', $community->id)
            ->likesCount()
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

            if (Auth::check()) {
                $isFollowing = UserCommunity::where('user_id', Auth::user()->id)->where('community_id', $community->id)->count();
            }

            $latestComments = Comment::whereHas('post', function ($q) use ($community) {
                $q->where('community_id', $community->id);
            })->orderBy('created_at', 'DESC')->with('user')->limit(8)->get();

            // return $communityPosts;
            return view('main.community', [
                'community' => $community,
                'posts' => $posts,
                'latestComments' => $latestComments,
                'isFollowing' => Auth::check() ? $isFollowing : 0,
                'tab' => 'latest'
            ]);
        }

        // get popular posts in specific community
        else if ($status == 'popular') {
            $community = Community::where('slug', $slug)->first();
            $posts = Post::where('community_id', $community->id)
            ->likesCount()
            ->orderBy('number_visites', 'DESC')
            ->paginate(10);


            if (Auth::check()) {
                $isFollowing = UserCommunity::where('user_id', Auth::user()->id)->where('community_id', $community->id)->count();
            }

            $latestComments = Comment::whereHas('post', function ($q) use ($community) {
                $q->where('community_id', $community->id);
            })->orderBy('created_at', 'DESC')->with('user')->limit(8)->get();


            return view('main.community', [
                'community' => $community,
                'posts' => $posts,
                'latestComments' => $latestComments,
                'isFollowing' => Auth::check() ? $isFollowing : 0,
                'tab' => 'popular'
            ]);
        }
    }
}
