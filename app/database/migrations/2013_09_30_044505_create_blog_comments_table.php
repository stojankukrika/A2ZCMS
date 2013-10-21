<?php

use Illuminate\Database\Migrations\Migration;

class CreateBlogCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create the `Comments` table
		Schema::create('blog_comments', function($table)
		{
            $table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->integer('user_id')->unsigned();			
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('blog_id')->unsigned();			
			$table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
			$table->text('content');
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
		// Delete the `Comments` table
		Schema::drop('blog_comments');
	}

}
