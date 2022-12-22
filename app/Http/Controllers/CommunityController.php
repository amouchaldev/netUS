<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Community;
use App\Models\UserCommunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    public function index() {
        return view('main.communities', [
            'communities' => Community::withCount('users')->get()
        ]);
    }


    public function community($slug, $status = null) {

         // get all posts that belongs to specific community
         if (!$status) {
             $communityPosts = Community::whereSlug($slug)->with('posts', function ($q) {
                $q->orderBy('created_at', 'DESC')->withCount(['comments',
                'likes as likes_count' => function ($q) { $q->where('vote', 1);},
                'likes as dislikes_count' => function ($q) { $q->where('vote', 0);},
                 ])->limit(8);
             })->first();        
             if (Auth::check()) {
            $isFollowing = UserCommunity::where('user_id', Auth::user()->id)->where('community_id', $communityPosts->id)->count();
             }
             $latestComments = Comment::whereHas('post', function ($q) use($communityPosts) {
                $q->where('community_id', $communityPosts->id);
             })->orderBy('created_at', 'DESC')->with('user')->limit(8)->get();

            // return $communityPosts;
            return view('main.community', [
                'communityPosts' => $communityPosts,
                'latestComments' => $latestComments,
                'isFollowing' => Auth::check() ? $isFollowing : 0,
                'tab' => 'latest'
            ]);
        }
        
        // get popular posts in specific community
        else if ($status == 'popular'){
                $communityPosts = Community::whereSlug($slug)->with('posts', function ($q) {
                    $q->orderBy('number_visites', 'DESC')->withCount(['comments',
                    'likes as likes_count' => function ($q) { $q->where('vote', 1);},
                    'likes as dislikes_count' => function ($q) { $q->where('vote', 0);}
                     ])->limit(8);
                })->first();
                if (Auth::check()) {
                    $isFollowing = UserCommunity::where('user_id', Auth::user()->id)->where('community_id', $communityPosts->id)->count();
                }    

                $latestComments = Comment::whereHas('post', function ($q) use($communityPosts) {
                    $q->where('community_id', $communityPosts->id);
                 })->orderBy('created_at', 'DESC')->with('user')->limit(8)->get();
    
                
                return view('main.community', [
                    'communityPosts' => $communityPosts,
                    'latestComments' => $latestComments,
                    'isFollowing' => Auth::check() ? $isFollowing: 0,
                    'tab' => 'popular'
                ]);
        }
    }

}
