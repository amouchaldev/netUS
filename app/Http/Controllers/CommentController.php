<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

}
