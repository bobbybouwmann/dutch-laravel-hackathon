<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Package;
use App\User;
use Faker\Generator as Faker;

$factory->define(Package::class, function (Faker $faker) {
    return [
        'user_id'   => function () {
            return factory(User::class);
        },
        'vendor'                => $faker->lastName,
        'number_of_packages'    => $faker->numberBetween(0, 200),
        'github_stars'          => $faker->numberBetween(0, 200),
        'favers'                => $faker->numberBetween(0, 100),
        'package_dependents'    => $faker->numberBetween(0, 20),
        'downloads_total'       => $faker->numberBetween(0, 9000),
        'downloads_monthly'     => $faker->numberBetween(0, 10000),
        'downloads_daily'       => $faker->numberBetween(0, 2000),
        'created_at'            => now(),
    ];
});
