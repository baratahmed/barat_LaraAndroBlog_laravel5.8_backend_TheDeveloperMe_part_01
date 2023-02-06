<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => rand(1,10),
        'desc' => $faker->text(),
        'photo' => $faker->imageUrl(640, 480, 'animals', true),
    ];
});
