<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotPrivilageRoleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('privilage_role', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('privilage_id')->unsigned()->index();
			$table->integer('role_id')->unsigned()->index();
			$table->foreign('privilage_id')->references('id')->on('privilages')->onDelete('cascade');
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
		});
	}



	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('privilage_role');
	}

}
