<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGalleryCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gallery_comments', function(Blueprint $table) {
			  $table->engine = 'InnoDB';
			$table->increments('id')->unsigned();
			$table->integer('user_id')->unsigned();			
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('gallery_id')->unsigned();			
			$table->foreign('gallery_id')->references('id')->on('gallery')->onDelete('cascade');
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
		Schema::drop('gallery_comments');
	}

}
