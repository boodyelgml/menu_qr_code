<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\restaurant;
use Faker\Generator as Faker;

$factory->define(restaurant::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'type' => $faker->text(10),
        'address' => $faker->address,
        'website' => $faker->email,
        'logo' => 'food-placeholder.png',
        'description' => $faker->text(50),
        'theme' => 2,
        'phone_number' => $faker->phoneNumber,
        'user_id' => $faker->numberBetween(1,100),
        'created_at' => now(),

    ];
});
