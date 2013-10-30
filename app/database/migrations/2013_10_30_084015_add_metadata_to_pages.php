<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddMetadataToPages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('pages', function(Blueprint $table) {
			$table -> string('meta_title');
			$table -> string('meta_description');
			$table -> string('meta_keywords');
			$table -> text('page_css');
			$table -> text('page_javascript');
			$table -> boolean('sidebar');
			$table -> boolean('showtitle');
			$table -> boolean('showvote');
			$table -> boolean('showdate');
			$table -> integer('voteup');
			$table -> integer('votedown');
			$table -> string('password');
			$table -> integer('hits');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('pages', function(Blueprint $table) {
			$table -> dropColumn('meta_title');
			$table -> dropColumn('meta_description');
			$table -> dropColumn('meta_keywords');
			$table -> dropColumn('page_css');
			$table -> dropColumn('page_javascript');
			$table -> dropColumn('sidebar');
			$table -> dropColumn('showtitle');
			$table -> dropColumn('showvote');
			$table -> dropColumn('showdate');
			$table -> dropColumn('voteup');
			$table -> dropColumn('votedown');
			$table -> dropColumn('password');
			$table -> dropColumn('hits');

		});
	}

}
