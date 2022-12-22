<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\PostCommented;
use App\Events\Reaction;

class CommentController extends Controller
{
    
    public function store($id, Request $request) {
        // return $id;
        // die();
        $request->validate([
            'body' => 'required',
        ]);
        $comment = new Comment();
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $id;
        $comment->body = $request['body'];
        if ($comment->save()) {
            event(new PostCommented($comment));
            return redirect()->to( app('url')->previous() . '#comments');
        }
    }

    public function delete($id) {
        Comment::destroy($id);
        return redirect()->to(app('url')->previous(). '#comments');
    }
    
    public function update($id, Request $request) {
        $comment = Comment::find($id);
        $comment->body = $request->newComment;
        $comment->update();
        
       return response()->json([
        'comment' => $request->newComment,
        'id' => $id,
        'message' => 'comment updated successfully',
        'status' => true
       ]);
    }


     // like and dislike
     public function action($comment_id, $action) {
        if (Auth::check()) {
            // check if user already exists in post_votes table
            $alreadyLike = CommentVote::where('user_id', Auth::user()->id)
            ->where('comment_id', $comment_id)
            ->where('vote', 1)
            ->count() > 0;
            $alreadyDislike = CommentVote::where('user_id', Auth::user()->id)
            ->where('comment_id', $comment_id)
            ->where('vote', 0)
            ->count() > 0;
            // user not like or dislike post yet
            if (!$alreadyLike && !$alreadyDislike) {
                $vote = new CommentVote();
                $vote->user_id = Auth::user()->id;
                $vote->comment_id = $comment_id;
                $vote->vote = $action == 'like' ? 1 : 0;
                $vote->save();

                $likes_count = CommentVote::where('comment_id', $comment_id)->where('vote', 1)->count() - CommentVote::where('comment_id', $comment_id)->where('vote', 0)->count();
                event(new Reaction('comments', $comment_id, $likes_count));
              

                return response()->json([
                    'message' => 'OK',
                    'status' => true, 
                    'likes_count' => $likes_count
                ]);
            }
            // dislike post
            else if ($alreadyLike && $action == 'dislike') {
                $vote = CommentVote::where('user_id', Auth::user()->id)->where('comment_id', $comment_id)->update([
                    'vote' => 0
                ]);

                $likes_count = CommentVote::where('comment_id', $comment_id)->where('vote', 1)->count() - CommentVote::where('comment_id', $comment_id)->where('vote', 0)->count();
                event(new Reaction('comments', $comment_id, $likes_count));

                return response()->json([
                    'message' => 'DISLIKED',
                    'status' => true,
                    'likes_count' => $likes_count

                ]);
            }
            // like post 
            else if ($alreadyDislike && $action == 'like') {
                $vote = CommentVote::where('user_id', Auth::user()->id)->where('comment_id', $comment_id)->update([
                    'vote' => 1
                ]);
                
                $likes_count = CommentVote::where('comment_id', $comment_id)->where('vote', 1)->count() - CommentVote::where('comment_id', $comment_id)->where('vote', 0)->count();
                event(new Reaction('comments', $comment_id, $likes_count));
                
                return response()->json([
                    'message' => 'LIKED',
                    'status' => true,
                    'likes_count' => $likes_count

                ]);
            }
            // pull like or dislike
            else if ($alreadyLike || $alreadyDislike) {
                $vote = CommentVote::where('user_id', Auth::user()->id)->where('comment_id', $comment_id);
                $vote->delete();

                $likes_count = CommentVote::where('comment_id', $comment_id)->where('vote', 1)->count() - CommentVote::where('comment_id', $comment_id)->where('vote', 0)->count();
                event(new Reaction('comments', $comment_id, $likes_count));

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
