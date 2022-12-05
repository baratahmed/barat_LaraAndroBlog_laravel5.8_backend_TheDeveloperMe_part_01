<?php

use Illuminate\Http\Request;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');
Route::get('logout', 'Api\AuthController@logout');
Route::post('save_user_info', 'Api\AuthController@saveUserInfo')->middleware('JWTAuth');


// Posts
Route::get('posts', 'Api\PostsController@index')->middleware('JWTAuth');
Route::get('posts/my_posts', 'Api\PostsController@myPosts')->middleware('JWTAuth');
Route::post('posts/store', 'Api\PostsController@store')->middleware('JWTAuth');
Route::post('posts/update', 'Api\PostsController@update')->middleware('JWTAuth');
Route::post('posts/delete', 'Api\PostsController@destroy')->middleware('JWTAuth');

// Comments
Route::post('posts/comments', 'Api\CommentsController@index')->middleware('JWTAuth');
Route::post('comments/store', 'Api\CommentsController@store')->middleware('JWTAuth');
Route::post('comments/update', 'Api\CommentsController@update')->middleware('JWTAuth');
Route::post('comments/delete', 'Api\CommentsController@destroy')->middleware('JWTAuth');

// Like
Route::post('posts/like', 'Api\LikesController@like')->middleware('JWTAuth');

// Route::group([
//     'middleware' => 'api',
//     'namespace' => 'App\Http\Controllers',
//     'prefix' => 'auth'
// ], function ($router) {
// });


