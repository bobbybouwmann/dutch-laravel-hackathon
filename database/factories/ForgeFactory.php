<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Forge;
use App\User;
use Faker\Generator as Faker;

$factory->define(Forge::class, function (Faker $faker) {
    return [
        'user_id'       => function () {
            return factory(User::class)->create();
        },
        'api_token'     => $faker->word,
        'servers'       => $faker->numberBetween(0, 10),
        'sites'         => $faker->numberBetween(0, 100),
        'created_at'    => now(),
    ];
});
