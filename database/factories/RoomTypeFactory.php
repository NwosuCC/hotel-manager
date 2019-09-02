<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\RoomType;
use Faker\Generator as Faker;

$factory->define(RoomType::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
//        'price' => $faker->numberBetween(80, 1150) + ($faker->numberBetween(0, 9) / 10)
        'price' => abs(rand(80, 1150)) / 10
    ];
});
