<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddDeletedAtIntoPages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('navigation_groups', function(Blueprint $table) {
			$table -> softDeletes();
		});
		Schema::table('navigation_links', function(Blueprint $table) {
			$table -> softDeletes();
		});
		Schema::table('pages', function(Blueprint $table) {
			$table -> softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('navigation_groups', function(Blueprint $table) {
			$table -> dropColumn('deleted_at');
			
		});
		Schema::table('navigation_links', function(Blueprint $table) {
			$table -> dropColumn('deleted_at');
			
		});
		Schema::table('pages', function(Blueprint $table) {
			$table -> dropColumn('deleted_at');
			
		});
	}

}
