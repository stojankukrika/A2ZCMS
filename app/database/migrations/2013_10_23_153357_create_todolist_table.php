<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTodolistTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('todolist', function(Blueprint $table) {
			$table -> increments('id');
			$table -> integer('user_id') -> unsigned();
			$table -> foreign('user_id') -> references('id') -> on('users');
			$table -> text('content');
			$table -> boolean('work_done');
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
		Schema::drop('todolist');
	}

}
