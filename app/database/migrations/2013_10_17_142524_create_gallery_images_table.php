<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGalleryImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('gallery_images', function(Blueprint $table) {
			$table -> increments('id');
			$table -> integer('gallery_id') -> unsigned();
			$table -> foreign('gallery_id') -> references('id') -> on('gallerys') -> onDelete('cascade');
			$table -> integer('user_id') -> unsigned();
			$table -> foreign('user_id') -> references('id') -> on('users') -> onDelete('cascade');
			$table -> string('content');
			$table -> integer('voteup') -> unsigned() -> default(0);
			$table -> integer('votedown') -> unsigned() -> default(0);
			$table -> integer('hits') -> unsigned() -> default(0);
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
		Schema::drop('gallery_images');
	}

}
