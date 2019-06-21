<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Certificate;
use App\User;
use Faker\Generator as Faker;

$factory->define(Certificate::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return  factory(User::class);
        },
        'date_of_certification' => $faker->date,
        'valid' => $faker->boolean,
        'created_at' => now(),
    ];
});
