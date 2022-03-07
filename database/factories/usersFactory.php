<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\users;
use Faker\Generator as Faker;

$factory->define(users::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
         'phone_number' => '010649687987',
         'password'=> bcrypt('123456'),
        'role' => 2

    ];
});
