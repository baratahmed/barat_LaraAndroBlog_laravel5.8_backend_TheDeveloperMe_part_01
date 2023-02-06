<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'user_id' => rand(1,10),
        'post_id' => rand(1,100),
        'comment' => $faker->sentence(3)
    ];
});
