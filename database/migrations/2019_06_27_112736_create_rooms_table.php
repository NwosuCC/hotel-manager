<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('name'); // e.g. A1,B2, C4
          $table->unsignedBigInteger('hotel_id');
          $table->unsignedBigInteger('room_type_id');
          $table->unsignedBigInteger('image_file_id')->nullable();
          $table->timestamps();
          $table->softDeletes();

          $table->unique(['name', 'hotel_id']);

          $table
            ->foreign('hotel_id')
            ->references('id')->on('hotels')->onUpdate('cascade');

          $table
            ->foreign('room_type_id')
            ->references('id')->on('room_types')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
