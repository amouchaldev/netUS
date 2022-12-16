<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\PostVote;
use App\Models\UserCommunity;
use Illuminate\Support\Str;
class PostController extends Controller
{
    public function index($status = null) {
        if (!$status) {
            // posts for authenticated user
            if (Auth::check()) {
                // get communities that current user not followed yet as recommended communities 
                $recommendedCommunities = Community::whereDoesntHave('users')->inRandomOrder()->get();
                // get all posts that belongs that Authenticated user follow
                $followedCommunities = Community::whereHas('users', function ($q) {
                    $q->whereId(Auth::user()->id);
                })->get('id');
                $posts = Post::whereIn('community_id', $followedCommunities)->with('community', 'user')->withCount(['comments', 'likes' => function ($q) { $q->where('vote', 1); }])->get();
                return view('main.index', [
                    'posts' => $posts,
                    'recommendedCommunities' => $recommendedCommunities,
                    'tab' => 'latest'
                ]);
            }
            // posts for non authenticated users
            else {
                // get random communities
                $recommendedCommunities = Community::inRandomOrder()->limit(10)->get();
                // get random posts
                $posts = Post::inRandomOrder()->with('community', 'user')->withCount(['comments', 'likes' => function ($q) { $q->where('vote', 1); }])->limit(7)->get();
                return view('main.index', [
                    'posts' => $posts,
                    'recommendedCommunities' => $recommendedCommunities,
                    'tab' => 'latest'
                ]);
            }
        }
        else if ($status == 'popular') {
            // posts for authenticated user
            if (Auth::check()) {
                // get communities that current user not followed yet as recommended communities 
                $recommendedCommunities = Community::whereDoesntHave('users')->get();
                // get all posts that belongs that Authenticated user follow
                $followedCommunities = Community::whereHas('users', function ($q) {
                    $q->whereId(Auth::user()->id);
                })->get('id');
                $posts = Post::whereIn('community_id', $followedCommunities)->with('community', 'user')->withCount(['comments', 'likes' => function ($q) { $q->where('vote', 1); }])->orderBy('number_visites', 'DESC')->limit(7)->get();
                return view('main.index', [
                    'posts' => $posts,
                    'recommendedCommunities' => $recommendedCommunities,
                    'tab' => 'popular'
                ]);
            }
            // posts for non authenticated users
            else {
                // get random communities
                $recommendedCommunities = Community::inRandomOrder()->limit(10)->get();
                // get random posts
                $posts = Post::with('community', 'user')->withCount(['comments', 'likes' => function ($q) { $q->where('vote', 1); }])->orderBy('number_visites', 'DESC')->limit(7)->get();
                return view('main.index', [
                    'posts' => $posts,
                    'recommendedCommunities' => $recommendedCommunities,
                    'tab' => 'popular'

                ]);
            }        
        }   
    }
   
    public function create() {
        $recommendedCommunities = Community::whereDoesntHave('users')->get(); 
        return view('main.posts.create', [
            'recommendedCommunities' => $recommendedCommunities
            ]);
    }

    public function edit($slug) {
        $recommendedCommunities = Community::whereDoesntHave('users')->get(); 
        $post = Post::where('slug', $slug)->with('community')->first();
        // return $post;
        // die();
        return view('main.posts.edit', [
            'post' => $post,
            'recommendedCommunities' => $recommendedCommunities

        ]);
    }

    public function update($id, Request $request) {
   
        $post = post::find($id);
        $post->title = $request->title;
        $post->body = $request->body;
        $post->community_id = $request->community;
        $post->save();
        return redirect()->route('posts.show', $post->slug);
    }

    public function store(Request $request) {
        $request->validate([
            'community' => 'required',
            'title' => 'required', 
            'body' => 'required'
        ]);
        $post = new Post();
        $post->title = $request['title'];
        $post->author_id = Auth::user()->id;
        $post->slug = Str::slug($request['title'], '-');
        $post->community_id = $request['community'];
        $post->body = $request['body'];
        if($post->save()) return redirect()->route('posts.show', $post->slug);
    }


    public function show($slug) {
        $recommendedCommunities = Community::whereDoesntHave('users')->get();
        
        // $post = Post::whereSlug($slug)->with(['community', 'user'])
        // ->withCount(['comments', 'likes' => function ($q) { $q->where('vote', 1); }])->first();

        $post = Post::whereSlug($slug)->with(['community', 'user'])
        ->withCount(['comments', 'likes' => function ($q) { $q->where('vote', 1); }])->first();

        $post->number_visites++;
        $post->save();
        $comments = Comment::where('post_id', $post->id)->with('user')->orderBy('created_at', 'DESC')->get();
        // $likes_count = $post->likes;
        // return $post->likes;
        return view('main.post', [
            'post' => $post,
            'recommendedCommunities' => $recommendedCommunities,
            'comments' => $comments
        ]);
    }


    

    public function delete($id) {
        
        Post::destroy($id);
        return response()->json([
            'message' => 'Post Deleted Successfully',
            'status' => true,
            // 'id' => $id
        ]);
    }
    // like and dislike
    public function action($id, $action) {
        if (Auth::check()) {
            // check if user already exists in post_votes table
            $alreadyLike = PostVote::where('user_id', Auth::user()->id)
            ->where('post_id', $id)
            ->where('vote', 1)
            ->count() > 0;
            $alreadyDislike = PostVote::where('user_id', Auth::user()->id)
            ->where('post_id', $id)
            ->where('vote', 0)
            ->count() > 0;
            // user not like or dislike post yet
            if (!$alreadyLike && !$alreadyDislike) {
                $vote = new PostVote();
                $vote->user_id = Auth::user()->id;
                $vote->post_id = $id;
                $vote->vote = $action == 'like' ? 1 : 0;
                $vote->save();
                // $likes_count =  
                return response()->json([
                    'message' => 'OK',
                    'status' => true
                ]);
            }
            // dislike post
            else if ($alreadyLike && $action == 'dislike') {
                $vote = PostVote::where('user_id', Auth::user()->id)->where('post_id', $id)->first();
                $vote->vote = 0;
                $vote->update();
                return response()->json([
                    'message' => 'DISLIKED',
                    'status' => true
                ]);
            }
            // like post 
            else if ($alreadyDislike && $action == 'like') {
                $vote = PostVote::where('user_id', Auth::user()->id)->where('post_id', $id)->first();
                $vote->vote = 1;
                $vote->update();
                return response()->json([
                    'message' => 'LIKED',
                    'status' => true
                ]);
            }
            // pull like or dislike
            else if ($alreadyLike || $alreadyDislike) {
                $vote = PostVote::where('user_id', Auth::user()->id)->where('post_id', $id);
                $vote->delete();
                return response()->json([
                    'message' => 'DELETED',
                    'status' => true
                ]);
            }
          
        } 
        else {
            return response()->json([
                'message' => 'NOT AUTHENTICATED',
                'status' => false
            ]);
        }
    }

}
