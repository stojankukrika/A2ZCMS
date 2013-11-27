<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddIsAdminIntoRoles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('roles', function(Blueprint $table) {
			$table -> boolean('is_admin')->after('name')->nullable()-> default(0);
		});
		
		Schema::table('permissions', function(Blueprint $table) {
			$table -> boolean('is_admin')->after('display_name')->nullable()-> default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('roles', function(Blueprint $table) {
			$table -> dropColumn('is_admin');			
		});
		Schema::table('permissions', function(Blueprint $table) {
			$table -> dropColumn('is_admin');			
		});
	}

}
