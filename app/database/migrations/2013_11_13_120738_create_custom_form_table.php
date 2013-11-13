<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomFormTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('custom_forms', function(Blueprint $table) {
			$table -> increments('id');
			$table -> integer('user_id')->unsigned()->index();
			$table -> foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table -> string('title');
			$table -> text('recievers');
			$table -> text('message');			
			$table -> timestamps();
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
		Schema::drop('custom_forms');
	}

}
