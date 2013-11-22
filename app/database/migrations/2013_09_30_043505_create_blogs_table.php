<?php

use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('blogs', function($table) {
			$table -> engine = 'InnoDB';
			$table -> increments('id') -> unsigned();
			$table -> integer('user_id') -> unsigned();
			$table -> foreign('user_id') -> references('id') -> on('users');
			$table -> string('title');
			$table -> string('slug');
			$table -> text('content');
			$table -> date('start_publish');
			$table -> date('end_publish') -> nullable();
			$table -> string('resource_link') -> nullable();			
			$table -> string('image')->nullable();
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
		Schema::drop('blogs');
	}

}
