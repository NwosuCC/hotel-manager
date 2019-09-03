<?php

use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeStartAndEndDatesNullable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    // NOTE: As of 20190903, \Doctrine\DBAL\Types\Type does not have type 'timestamp'. Therefore, defaulting to 'date_time' type
    Schema::table('bookings', function (Blueprint $table) {
      $table->dateTime('start_date')->nullable(true)->change();
      $table->dateTime('end_date')->nullable(true)->change();
    });
  }

  /**
   * Reverse the migrations.
   *
   * Essentially same process as up() except the 'nullable()' property is now dropped again
   *
   * @return void
   */
  public function down()
  {
    Schema::table('bookings', function (Blueprint $table) {
      $table->dateTime('start_date')->nullable(false)->change();
      $table->dateTime('end_date')->nullable(false)->change();
    });
  }
}
