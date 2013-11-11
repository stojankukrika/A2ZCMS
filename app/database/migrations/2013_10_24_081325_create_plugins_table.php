<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePluginsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('plugins', function(Blueprint $table) {
			$table -> increments('id');
			$table -> string('content');
			$table -> string('function_id') -> nullable();
			$table -> string('function_grid') -> nullable();
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
		Schema::drop('plugins');
	}

}
