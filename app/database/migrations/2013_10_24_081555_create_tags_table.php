<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('tags', function(Blueprint $table) {
			$table -> increments('id');
			$table -> string('content');
			$table -> integer('itemid');
			$table -> integer('plugin_id') -> unsigned();
			$table -> foreign('plugin_id') -> references('id') -> on('plugins') -> onDelete('cascade');
			$table -> boolean('active');
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
		Schema::drop('tags');
	}

}
