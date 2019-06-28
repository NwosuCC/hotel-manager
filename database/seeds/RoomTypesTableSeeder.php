<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(\App\Models\RoomType::class, 4)->create();

//      $values = [
//        ['name' => 'Deluxe'],
//        ['name' => 'High-Class'],
//        ['name' => 'Standard'],
//        ['name' => 'Cool-n-Cozy'],
//      ];
//
//      DB::table('room_types')->insert( $values );
    }
}
