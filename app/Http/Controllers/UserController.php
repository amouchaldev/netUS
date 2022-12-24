<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    
    public function show($username) {
        if (Auth::check()) {
            $user = Cache::remember('user-'.$username, now()->addMonths(3), function () use($username){
                return User::where('username', $username)
                ->withTrashed()->first();
            });

            $posts = Post::where('author_id', $user->id)
            ->withCount('comments')->paginate(7);

            $contentViews = DB::table('posts')
            ->select(DB::raw("sum(number_visites) as contentView"))
            ->where('author_id', $user->id)
            ->pluck('contentView');
            // return $posts;
            return view('main.user', [
                'user' => $user,
                'posts' => $posts,
                'contentViews' => $contentViews[0]
            ]);
        }
        else {
            $user = User::where('username', $username)->first();
            if ($user) {
                $posts = Post::where('author_id', $user->id)
                ->withCount('comments')->paginate(7);
                $contentViews = DB::table('posts')
                ->select(DB::raw("sum(number_visites) as contentView"))
                ->where('author_id', $user->id)
                ->pluck('contentView');
                return view('main.user', [
                    'user' => $user,
                    'posts' => $posts,
                    'contentViews' => $contentViews[0]
                ]);
            }
            else {
                return abort(404);
            }
        }
    }


    public function delete($id) {
        $user = User::find($id);
        Gate::authorize('delete', $user);
        $user->delete();
        return redirect()->back();
    }

    public function restore($id) {
        $user = User::onlyTrashed()->whereId($id)->first();
        
        Gate::authorize('restore', $user);
        $user->restore();

        return back();
    }

    public function pendingUsers() {
        $this->authorize('acceptMembers', User::class);
        return view('main.pendingUsers', ['pendingUsers' => User::where('role', null)->get()]);
        
        // return view('li');
    }
    public function activeNewAcc($id) {
        $this->authorize('acceptMembers', User::class);
        User::whereId($id)->update(['role' => 'membre']);
        return redirect()->back();

    }
}
