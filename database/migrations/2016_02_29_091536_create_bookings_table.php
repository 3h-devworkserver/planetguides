<?php

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
             $table->increments('id');
             $table->integer('gid');
             $table->integer('uid');
             $table->smallInteger('days')->default(0);
             $table->timestamp('start_date');
             $table->timestamp('end_date');
             $table->smallInteger('verified')->default(0);
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
        Schema::drop('bookings');
    }
}
