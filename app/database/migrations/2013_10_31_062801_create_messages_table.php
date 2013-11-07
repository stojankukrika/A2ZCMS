<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMeesagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function(Blueprint $table) {
			$table->increments('id');
			$table -> integer('user_id_from') -> unsigned();
			$table -> foreign('user_id_from') -> references('id') -> on('users');
			$table -> integer('user_id_to') -> unsigned();
			$table -> foreign('user_id_to') -> references('id') -> on('users');
			$table -> string('subject');
			$table -> text('content');
			$table -> boolean('read');
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
		Schema::drop('messages');
	}

}
