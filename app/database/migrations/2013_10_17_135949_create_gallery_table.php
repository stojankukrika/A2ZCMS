<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGalleryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gallery', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('user_id')->unsigned();		
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('gallerycategory_id')->unsigned()->index();
			$table->foreign('gallerycategory_id')->references('id')->on('gallery_categorys');
			$table->string('title');
			$table->integer('views')->unsigned()->default(0);
			$table->date('start_publish');
			$table->date('end_publish')->nullable();
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
		Schema::drop('gallery');
	}

}
