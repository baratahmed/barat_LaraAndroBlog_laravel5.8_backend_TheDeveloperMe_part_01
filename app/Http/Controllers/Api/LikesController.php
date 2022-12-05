<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Like;

class LikesController extends Controller
{
    public function like(Request $request){
        $like = Like::where('post_id',$request->id)->where('user_id',auth()->id())->first();
        if(isset($like)){
            $like->delete();
            return response()->json([
                'success' => true,
                'message' => 'Post Unliked'
            ]);
        }
        $like = new Like;
        $like->user_id = auth()->id();
        $like->post_id = $request->id;
        $like->save();

        return response()->json([
            'success' => true,
            'message' => 'Post Liked'
        ]);
    }
}
