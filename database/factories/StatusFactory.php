<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Status;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'title' => $faker->words(rand(3, 6), true),
        'description' => rand(0, 1) ? $faker->sentence : null,
        'order' => 0,
        'user_id' => factory(App\User::class),
        'status_id' => factory(App\Status::class)
    ];
});
