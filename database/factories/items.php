<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\items;
use Faker\Generator as Faker;

$factory->define(items::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'name_ar' => $faker->name,
        'description' => $faker->text(50),
        'description_ar' => $faker->text(50),
        'photo' => $faker->text(5),
        'price' => $faker->numberBetween(30, 70),
        'is_visible' => $faker->boolean(),
        'sort_no' => $faker->numberBetween(1, 10),
        'restaurant_id' => $faker->numberBetween(4, 100),
        'created_at' => now(),
     ];
});
