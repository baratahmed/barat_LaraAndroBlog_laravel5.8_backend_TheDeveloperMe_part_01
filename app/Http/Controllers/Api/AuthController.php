<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only(['email','password']);
        $token = auth()->attempt($credentials);
        if(!$token){
            return response()->json([
                'success' => false,
                'message' => 'Invalid Credentials'
            ]);
        }
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => Auth::user()
        ]);
    }

    public function register(Request $request){
        $encryptedPassword = Hash::make($request->password);
        $user = new User;

        try {
            $user->email = $request->email;
            $user->password = $encryptedPassword;
            $user->save();
            return $this->login($request);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => ''.$e
            ]);
        }
    }

    public function saveUserInfo(Request $request){
        $user = auth()->user();
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $photo = "";
        if($request->photo != ''){
            $photo = time().'.jpg';
            file_put_contents('storage/profiles/'.$photo, base64_decode($request->photo));
            $user->photo = $photo;
        }else{
            $user->photo = 'default.jpg';
        }

        $user->update();

        return response()->json([
            'success' => true,
            'photo' => $photo
        ]);

    }

    public function logout(Request $request){
        try {
            JWTAuth::invalidate(JWTAuth::parseToken($request->token));
            return response()->json([
                'success' => true,
                'message' => 'Logout Success'
            ]);
        
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => ''.$e
            ]);
        }
    }


}
