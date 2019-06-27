<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Hotel;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Hotel::class, function (Faker $faker) {
  return [
    'name' => $faker->company,
    'address' => $faker->streetAddress,
    'city' => $faker->city,
    'country' => $faker->country,
    'zip_code' => $faker->postcode,
    'phone_number' => $faker->unique()->phoneNumber,
    'email' => $faker->unique()->safeEmail,
  ];
});
