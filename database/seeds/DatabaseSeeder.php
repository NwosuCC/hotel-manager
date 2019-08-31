<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $this->call(UsersTableSeeder::class);
      $this->call(HotelsTableSeeder::class);
      $this->call(RoomTypesTableSeeder::class);
      $this->call(RoomsTableSeeder::class);
      $this->call(BookingsTableSeeder::class);

      Artisan::call('passport:install');
    }
}
