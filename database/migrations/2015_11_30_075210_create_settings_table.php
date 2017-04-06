<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('siteTitle');
            $table->string('description');
            $table->string('adminEmail');
            $table->integer('charges');
            $table->string('facebook');
            $table->string('twitter');
            $table->string('plus');
            $table->string('pinterest');
            $table->string('logo');
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
        Schema::drop('settings');
    }
}
