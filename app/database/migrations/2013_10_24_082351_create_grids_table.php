<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGridsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('grids', function(Blueprint $table) {
			$table -> increments('id');
			$table -> integer('plugin_id') -> unsigned();
			$table -> foreign('plugin_id') -> references('id') -> on('plugins') -> onDelete('cascade');
			$table -> integer('order');
			$table -> timestamps();
			$table -> softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('grids');
	}

}
