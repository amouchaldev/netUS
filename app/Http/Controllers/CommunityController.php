<?php

namespace App\Http\Controllers;

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
                $q->orderBy('number_visites', 'DESC')->withCount(['comments', 'likes' => function ($q) { $q->where('vote', 1); }])->limit(8);
             })->first();        
             if (Auth::check()) {
            $isFollowing = UserCommunity::where('user_id', Auth::user()->id)->where('community_id', $communityPosts->id)->count();
             }
            // return $communityPosts;
            return view('main.community', [
                'communityPosts' => $communityPosts,
                'isFollowing' => Auth::check() ? $isFollowing : 0,
                'tab' => 'latest'
            ]);
        }
        // get popular posts in specific community
        else if ($status == 'popular'){
                $communityPosts = Community::whereSlug($slug)->with('posts', function ($q) {
                    $q->orderBy('number_visites', 'DESC')->withCount(['comments', 'likes' => function ($q) { $q->where('vote', 1); }])->limit(8);
                })->first();
                if (Auth::check()) {
                    $isFollowing = UserCommunity::where('user_id', Auth::user()->id)->where('community_id', $communityPosts->id)->count();
                }        
                return view('main.community', [
                    'communityPosts' => $communityPosts,
                    'isFollowing' => Auth::check() ? $isFollowing: 0,
                    'tab' => 'popular'
                ]);
        }
    }
    // public function popular($slug) {
    // }

}
