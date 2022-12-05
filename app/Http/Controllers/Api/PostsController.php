<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id','desc')->get();
        foreach ($posts as $post) {
            $post->user;
            $post['commentsCount'] = count($post->comments);
            $post['likesCount'] = count($post->likes);
            $post['selfLike'] = false;
            foreach ($post->likes as $like) {
                if($like->user_id == auth()->id()){
                    $post['selfLike'] = true;
                }
            }
        }

        return response()->json([
            'success' => true,
            'posts' => $posts
            
        ]);


    }

    public function myPosts(){
        $posts = Post::where('user_id',auth()->id())->orderBy('id','desc')->get();
        $user = auth()->user();
        return response()->json([
            'success'=>true,
            'posts' => $posts,
            'user' => $user
        ]);

    }

    public function store(Request $request)
    {
        $post = new Post;
        $post->user_id = auth()->id();
        $post->desc = $request->desc;
        if($request->photo != ''){
            $photo = time().'.jpg';
            file_put_contents('storage/posts/'.$photo, base64_decode($request->photo));
            $post->photo = $photo;
        }else{
            $post->photo = 'default.jpg';
        }
        $post->save();
        $post->user;
        return response()->json([
            'success' => true,
            'message' => 'Post Created',
            'post' => $post
            
        ]);
    }

    public function update(Request $request)
    {
        $post = Post::find($request->id);
        if(auth()->id() != $post->user_id){
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized Access',                
            ]);
        }
        $post->desc = $request->desc;
        $post->save();
        return response()->json([
            'success' => true,
            'message' => 'Post Updated',            
        ]);
    }

    public function destroy(Request $request)
    {
        $post = Post::find($request->id);
        if(auth()->id() != $post->user_id){
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized Access',                
            ]);
        }
        if($post->photo != ''){
            Storage::delete('public/storage/posts/'.$post->photo);
        }
        $post->delete();
        return response()->json([
            'success' => true,
            'message' => 'Post Deleted',            
        ]);
    }
}
