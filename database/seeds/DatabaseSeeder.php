<?php

use App\Comment;
use App\Like;
use App\Post;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // factory(User::class,10)->create();
        // factory(Post::class,100)->create();
        // factory(Comment::class,500)->create();
        factory(Like::class,1000)->create();
    }
}
