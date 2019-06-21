<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laracast;
use App\User;
use Faker\Generator as Faker;

$factory->define(Laracast::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class);
        },
        'username' => $faker->firstName,
        'experience' => $faker->numberBetween(10000, 120000),
        'lessons' => $faker->numberBetween(1, 1000),
        'best_replies' => $faker->numberBetween(0, 100),
        'badge_beginner' => $faker->numberBetween(1, 10),
        'badge_intermediate' => $faker->numberBetween(0, 5),
        'badge_advanced' => $faker->numberBetween(0, 2),
        'created_at' => now(),
    ];
});
