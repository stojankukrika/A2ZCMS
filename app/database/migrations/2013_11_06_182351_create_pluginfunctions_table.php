<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePluginFunctionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('plugin_functions', function(Blueprint $table) {
			$table -> increments('id');
			$table -> string('title');
			$table -> integer('plugin_id') -> nullable() -> default(NULL);
			$table -> string('function');
			$table -> string('params');
			$table -> string('type');
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
		Schema::drop('plugin_functions');
	}

}
