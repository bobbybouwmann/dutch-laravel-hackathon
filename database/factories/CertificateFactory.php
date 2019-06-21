<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Certificate;
use App\User;
use Faker\Generator as Faker;

$factory->define(Certificate::class, function (Faker $faker) {
    return [
        'user_id'               => function () {
                                        return  factory(User::class);
                                    },
        'date_of_certification' => $faker->date,
        'valid'                 => $faker->boolean,
        'created_at'            => now(),
    ];
});
