<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('bookings', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('room_id');
      $table->unsignedBigInteger('user_id')->nullable();
      $table->timestamp('start_date');
      $table->timestamp('end_date');
      $table->string('customer_full_name');
      $table->string('customer_email');
      $table->decimal('current_price');
      $table->string('total_nights');
      $table->decimal('total_price');
      $table->timestamps();
      $table->softDeletes();

//      $table->unique(['room_id', 'start_date']); // requires even further validation

      $table
        ->foreign('room_id')
        ->references('id')->on('rooms')->onUpdate('cascade');

      $table
        ->foreign('user_id')
        ->references('id')->on('users')->onUpdate('cascade');

    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('bookings');
  }
}
