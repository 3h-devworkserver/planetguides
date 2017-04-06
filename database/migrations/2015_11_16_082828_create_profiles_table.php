<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('phone',20)->nullable();
            $table->string('state',40)->nullable();
            $table->string('city',40)->nullable();
            $table->string('country',40)->nullable();
            $table->string('zip',10)->nullable();
            $table->string('address',100)->nullable();
            $table->integer('experience')->nullable();
            $table->string('mGuidingArea',50)->nullable();
            $table->text('oGuidingArea')->nullable();
            $table->text('language')->nullable();
            $table->text('about')->nullable();
            $table->string('profileImg',150)->nullable();
            $table->string('bannerImg',200)->nullable();
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
        Schema::drop('Profiles');
    }
}
