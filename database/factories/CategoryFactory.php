<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\categories;
use Faker\Generator as Faker;
 $factory->define(categories::class, function (Faker $faker) {
     return [
        'name' => $faker->name,
         'description' => $faker->text(50),
        'photo' => $faker->text(5),
        'is_visible' => $faker->boolean(),
        'sort_no' => $faker->numberBetween(1, 10),
        'restaurant_id' => $faker->numberBetween(1,100),
        'created_at' => now(),
    ];
});


