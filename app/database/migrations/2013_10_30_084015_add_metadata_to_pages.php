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
			$table -> string('meta_title')->after('slug')-> nullable();
			$table -> string('meta_description')->after('meta_title')-> nullable();
			$table -> string('meta_keywords')->after('meta_description')-> nullable();
			$table -> text('page_css')->after('meta_keywords')-> nullable();
			$table -> text('page_javascript')->after('page_css');
			$table -> boolean('sidebar')->after('page_javascript');
			$table -> boolean('showtitle')->after('sidebar');
			$table -> boolean('showvote')->after('showtitle');
			$table -> boolean('showdate')->after('showvote');
			$table -> integer('voteup')->after('showdate');
			$table -> integer('votedown')->after('voteup');
			$table -> string('password')->after('votedown');
			$table -> integer('hits')->after('password');
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
