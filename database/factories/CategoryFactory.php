<?php

/** @var Factory $factory */
use App\Models\User;
use App\Models\Category;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->name,
        'description' => $faker->text,
        'user_id' => User::pluck('id')->random(1)->first(),
    ];
});
