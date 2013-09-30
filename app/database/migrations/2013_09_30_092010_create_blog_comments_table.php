<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlogcommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blog_comments', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('users_id')->unsigned()->index();
			$table->integer('blogs_id')->unsigned()->index();
			$table->foreign('blogs_id')->references('id')->on('blogs')->onDelete('cascade');
			$table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
			$table->text('body');
			$table->timestamps();
			$table->softDeletes();	
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('blog_comments');
	}

}
