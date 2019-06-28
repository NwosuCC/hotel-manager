<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Room;
use App\Models\Hotel;
use App\Models\RoomType;
use Faker\Generator as Faker;

$factory->define(Room::class, function (Faker $faker) {
  return [
    'name' => $faker->firstName,
    'hotel_id' => Hotel::query()->first()->id,
    'room_type_id' => ($room_type = RoomType::query()->get()) ? $room_type->random()->id : factory(RoomType::class)->create()->id
  ];
});
