<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\User;
use App\Models\Room;
use App\Models\Booking;
use Faker\Generator as Faker;

$factory->define(Booking::class, function (Faker $faker) {

  $rooms = Room::query()->get();

  $room = $rooms ? $rooms->random() : factory(Room::class)->create();

  return [
    'room_id' => $room->id,
    'start_date' => $start_date = now()->subDays( abs(rand(0, 4))),
    'end_date' => $end_date = now()->addDays( abs(rand(0, 9))),
    'customer_full_name' => $faker->name,
    'customer_email' => $faker->unique()->safeEmail,
    'current_price' => $current_price = $room->roomType->price ?: 0,
    'total_nights' => $total_nights = $end_date->diffInDays( $start_date ),
    'total_price' => ($current_price * $total_nights),
  ];

});

$factory->state(User::class, 'registered_user', function (Faker $faker){

  $users = User::query()->notAdmin()->get();

  $user = $users ? $users->random()->id : factory(User::class)->create();

  return [
    'user_id' => $user->id
  ];

});
