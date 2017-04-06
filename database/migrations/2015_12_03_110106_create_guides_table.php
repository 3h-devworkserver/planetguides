<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGuidesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('guides', function (Blueprint $table) {

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('gid');
			$table->enum('certified', ['0', '1'])->default('0');
			$table->integer('price')->nullable();
			$table->float('rating_cache')->unsigned();
			$table->integer('rating_count')->unsigned();
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('guides');
	}
}
