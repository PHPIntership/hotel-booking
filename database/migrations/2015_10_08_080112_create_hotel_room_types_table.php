<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelRoomTypesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('hotel_room_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('room_type_id')->unsigned()->index();
            $table->integer('hotel_id')->unsigned()->index();
            $table->string('name');
            $table->string('quality');
            $table->integer('quantity');
            $table->float('price');
            $table->string('image')->nullable();
            $table->text('description');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('hotel_room_types');
    }
}
