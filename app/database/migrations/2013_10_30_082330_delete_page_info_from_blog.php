<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DeletePageInfoFromBlog extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('blogs', function(Blueprint $table) {
			$table -> dropColumn('meta_title');
			$table -> dropColumn('meta_description');
			$table -> dropColumn('meta_keywords');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('blogs', function(Blueprint $table) {
			$table -> string('meta_title');
			$table -> string('meta_description');
			$table -> string('meta_keywords');
		});
	}

}
