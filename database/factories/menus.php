<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\menus;
use Faker\Generator as Faker;

$factory->define(menus::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text(50),
        'photo' => $faker->text(5),
        'is_visible' => $faker->boolean(),
        'sort_no' => $faker->numberBetween(1, 10),
        'restaurant_id' => $faker->numberBetween(4, 100),
        'created_at' => now(),
    ];
});
