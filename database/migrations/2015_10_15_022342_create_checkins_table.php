<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckinsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('checkins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('room_id')->unsigned()->index()->nulllabel();
            $table->integer('order_id')->unsigned()->index();
            $table->integer('hotel_admin_id')->unsigned()->index();
            $table->date('coming_date');
            $table->date('leave_date');
            $table->float('price');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('checkins');
    }
}
