<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminHotels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id');
            $table->string('username')->unique();
            $table->string('password',60);
            $table->string('name');
            $table->string('phone',15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin_hotels');
    }
}
