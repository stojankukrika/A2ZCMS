<?php

use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		// Create the `Blogs` table
		Schema::create('blogs', function($table) {
			$table -> engine = 'InnoDB';
			$table -> increments('id') -> unsigned();
			$table -> integer('user_id') -> unsigned();
			$table -> foreign('user_id') -> references('id') -> on('users');
			$table -> integer('blogcategory_id') -> unsigned() -> index();
			$table -> foreign('blogcategory_id') -> references('id') -> on('blog_categorys');
			$table -> string('title');
			$table -> string('slug');
			$table -> text('content');
			$table -> date('start_publish');
			$table -> date('end_publish') -> nullable();
			$table -> string('resource_link') -> nullable();
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
		// Delete the `Blogs` table
		Schema::drop('blogs');
	}

}
