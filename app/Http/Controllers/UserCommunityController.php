<?php

namespace App\Http\Controllers;

use App\Models\UserCommunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserCommunityController extends Controller
{
    
    public function follow(Request $request) {
  
        if (Auth::check()) {
            if(UserCommunity::where('user_id', Auth::user()->id)->where('community_id', $request['community_id'])->count() == 0) {
                $follow = Auth::user()
                ->communities()
                ->syncWithoutDetaching($request['community_id']);
                Cache::pull('recommendedCommunities');
                return response()->json([
                    'status' => 'followed',
                ], 200);
            }
            else {
                $follow = Auth::user()
                ->communities()
                ->detach($request['community_id']);
                return response()->json([
                    'status' => 'unfollowed',
                ], 200);  
            }
        }
        else {
            return response()->json([
                'status' => 'NOT AUTHENTICATED',
            ]);  
        }
    
     }
}
