<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNavigationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		Schema::create('navigation_groups', function(Blueprint $table) {
			$table -> increments('id');
			$table -> string('title') -> unique();
			$table -> string('abbrev') -> unique();
			$table -> timestamps();
		});

		Schema::create('navigation_links', function(Blueprint $table) {
			$table -> increments('id');
			$table -> string('title', 100) -> unique();
			$table -> unsignedInteger('parent') -> nullable() -> default(NULL);
			$table -> enum('link_type', array('url', 'uri', 'page')) -> default('page');
			$table -> unsignedInteger('page_id');
			$table -> string('url');
			$table -> string('uri');
			$table -> integer('navigation_group_id') -> unsigned();
			$table -> foreign('navigation_group_id') -> references('id') -> on('navigation_groups')-> onDelete('cascade');
			$table -> integer('position');
			$table -> enum('target', array('selected', '_blank')) -> default('selected');
			$table -> string('restricted_to');
			$table -> string('class', 50);
			$table -> timestamps();
			$table -> foreign('parent') -> references('id') -> on('navigation_links') -> onDelete('cascade');
			$table -> foreign('page_id') -> references('id') -> on('pages') -> onDelete('cascade');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('navigation_links');
		Schema::drop('navigation_groups');
	}

}
