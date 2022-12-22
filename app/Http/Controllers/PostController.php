<?php

namespace App\Http\Controllers;

use App\Events\Reaction;
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
                // get all posts that belongs that Authenticated user follow
                $followedCommunities = Community::whereHas('users', function ($q) {
                    $q->whereId(Auth::user()->id);
                })->get('id');
                $posts = Post::whereIn('community_id', $followedCommunities)->with('community', 'user')->withCount(['comments',
                'likes as likes_count' => function ($q) { $q->where('vote', 1);},
                'likes as dislikes_count' => function ($q) { $q->where('vote', 0);}
                 ])->get();
                return view('main.index', [
                    'posts' => $posts,
                    'tab' => 'latest'
                ]);
            }
            // posts for non authenticated users
            else {

                // get random posts
                $posts = Post::inRandomOrder()
                ->with('community', 'user')->withCount(['comments',
                'likes as likes_count' => function ($q) { $q->where('vote', 1);},
                'likes as dislikes_count' => function ($q) { $q->where('vote', 0);}
                 ])
                ->limit(7)->get();
                return view('main.index', [
                    'posts' => $posts,
                    'tab' => 'latest'
                ]);
            }
        }
        else if ($status == 'popular') {
            // posts for authenticated user
            if (Auth::check()) {
                // get all posts that belongs that Authenticated user follow
                $followedCommunities = Community::whereHas('users', function ($q) {
                    $q->whereId(Auth::user()->id);
                })->get('id');
                $posts = Post::whereIn('community_id', $followedCommunities)->with('community', 'user')->withCount(['comments',
                'likes as likes_count' => function ($q) { $q->where('vote', 1);},
                'likes as dislikes_count' => function ($q) { $q->where('vote', 0);}
                 ])
                 ->orderBy('number_visites', 'DESC')->limit(7)->get();
                return view('main.index', [
                    'posts' => $posts,
                    'tab' => 'popular'
                ]);
            }
            // posts for non authenticated users
            else {
                // get random posts
                $posts = Post::with('community', 'user')->withCount(['comments', 'likes' => function ($q) { $q->where('vote', 1); }])->orderBy('number_visites', 'DESC')->limit(7)->get();
                return view('main.index', [
                    'posts' => $posts,
                    'tab' => 'popular'

                ]);
            }        
        }   
    }
   
    public function create() {
        return view('main.posts.create');
    }

    public function edit($slug) {
        $post = Post::where('slug', $slug)->with('community')->first();
        return view('main.posts.edit', [
            'post' => $post,
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

        $post = Post::whereSlug($slug)
        ->with(['community', 'user'])
        ->withCount(['comments',
         'likes as likes_count' => function ($q) { $q->where('vote', 1);},
         'likes as dislikes_count' => function ($q) { $q->where('vote', 0);}
        ])->first();

        $post->number_visites++;
        $post->save();
        $comments = Comment::where('post_id', $post->id)->with('user')->withCount([
            'likes as likes_count' => function ($q) { $q->where('vote', 1); },
            'likes as dislikes_count' => function ($q) { $q->where('vote', 0); },
        ])->orderBy('created_at', 'DESC')->get();
        $alsoLearn = Post::where('community_id', $post->community->id)->inRandomOrder()->limit(6)->get();
        // $likes_count = $post->likes;
        // return $post->likes;
        return view('main.post', [
            'post' => $post,            
            'comments' => $comments,
            'alsoLearn' => $alsoLearn
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
    public function action($post_id, $action) {
        if (Auth::check()) {
            // check if user already exists in post_votes table
            $alreadyLike = PostVote::where('user_id', Auth::user()->id)
            ->where('post_id', $post_id)
            ->where('vote', 1)
            ->count() > 0;
            $alreadyDislike = PostVote::where('user_id', Auth::user()->id)
            ->where('post_id', $post_id)
            ->where('vote', 0)
            ->count() > 0;
            // user not like or dislike post yet
            if (!$alreadyLike && !$alreadyDislike) {

                $vote = new PostVote();
                $vote->user_id = Auth::user()->id;
                $vote->post_id = $post_id;
                $vote->vote = $action == 'like' ? 1 : 0;
                $vote->save();

                $likes_count = PostVote::where('post_id', $vote->post_id)
                ->where('vote', 1)->count() - PostVote::where('post_id', $vote->post_id)
                ->where('vote', 0)->count();

                event(new Reaction(
                            'posts',
                            $post_id,
                            // Auth::user()->fName . ' ' . Auth::user()->lName,
                            $likes_count
                ));
                
                return response()->json([
                    'message' => 'OK',
                    'status' => true, 
                    'likes_count' => $likes_count
                ]);

            }
            // dislike post
            else if ($alreadyLike && $action == 'dislike') {
                $vote = PostVote::where('user_id', Auth::user()->id)->where('post_id', $post_id)->update([
                    'vote' => 0
                ]);

                $likes_count = PostVote::where('post_id', $post_id)->where('vote', 1)->count() - PostVote::where('post_id', $post_id)->where('vote', 0)->count();
                event(new Reaction(
                    'posts',
                    $post_id,
                    // Auth::user()->fName . ' ' . Auth::user()->lName,
                    $likes_count
        ));
                return response()->json([
                    'message' => 'DISLIKED',
                    'status' => true,
                    'likes_count' => $likes_count

                ]);
            }
            // like post 
            else if ($alreadyDislike && $action == 'like') {
                $vote = PostVote::where('user_id', Auth::user()->id)->where('post_id', $post_id)->update([
                    'vote' => 1
                ]);
                
                $likes_count = PostVote::where('post_id', $post_id)->where('vote', 1)->count() - PostVote::where('post_id', $post_id)->where('vote', 0)->count();
                event(new Reaction(
                    'posts',
                    $post_id,
                    // Auth::user()->fName . ' ' . Auth::user()->lName,
                    $likes_count
        ));                
                return response()->json([
                    'message' => 'LIKED',
                    'status' => true,
                    'likes_count' => $likes_count

                ]);
            }
            // pull like or dislike
            else if ($alreadyLike || $alreadyDislike) {
                $vote = PostVote::where('user_id', Auth::user()->id)->where('post_id', $post_id);
                $vote->delete();

                $likes_count = PostVote::where('post_id', $post_id)->where('vote', 1)->count() - PostVote::where('post_id', $post_id)->where('vote', 0)->count();
                event(new Reaction(
                    'posts',
                    $post_id,
                    // Auth::user()->fName . ' ' . Auth::user()->lName,
                    $likes_count
        ));
                return response()->json([
                    'message' => 'DELETED',
                    'status' => true,
                    'likes_count' => $likes_count

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
