<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    public function index(Request $request)
    {

        $comments = Comment::where('post_id',$request->id)->get();
        foreach ($comments as $comment) {
            $comment->user;
        }

        return response()->json([
            'success' => true,
            'comments' => $comments            
        ]);


    }

    public function store(Request $request)
    {
        $comment = new Comment();
        $comment->user_id = auth()->id();
        $comment->post_id = $request->id;
        $comment->comment = $request->comment;
        $comment->save();
        $comment->user;

        return response()->json([
            'success' => true,
            'comment' => $comment,
            'message' => 'Comment Added',            
        ]);
    }

    public function update(Request $request)
    {
        $comment = Comment::find($request->id);
        if(auth()->id() != $comment->user_id){
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized Access',                
            ]);
        }
        $comment->comment = $request->comment;
        $comment->save();
        return response()->json([
            'success' => true,
            'message' => 'Comment Updated',            
        ]);
    }

    public function destroy(Request $request)
    {
        $comment = Comment::find($request->id);
        if(auth()->id() != $comment->user_id){
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized Access',                
            ]);
        }
        $comment->delete();
        return response()->json([
            'success' => true,
            'message' => 'Comment Deleted',            
        ]);
    }
}