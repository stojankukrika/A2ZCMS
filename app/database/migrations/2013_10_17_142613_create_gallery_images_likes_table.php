<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGalleryImagesLikesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('gallery_images_likes', function(Blueprint $table) {
			$table -> increments('id');
			$table -> integer('gallery_images_id') -> unsigned();
			$table -> foreign('gallery_images_id') -> references('id') -> on('gallery_images') -> onDelete('cascade');
			$table -> integer('user_id') -> unsigned();
			$table -> foreign('user_id') -> references('id') -> on('users') -> onDelete('cascade');
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
		Schema::drop('gallery_images_likes');
	}

}
