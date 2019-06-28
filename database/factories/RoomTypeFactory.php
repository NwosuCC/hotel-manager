<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\RoomType;
use Faker\Generator as Faker;

$factory->define(RoomType::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName
    ];
});
