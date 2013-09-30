<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterBlogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('blogs', function($table)
			{
			$table->renameColumn('body', 'content');
			$table->string('meta_title')->after('body');
			$table->string('meta_description')->after('meta_title');
			$table->string('meta_keywords')->after('meta_description');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('blogs', function($table)
			{
				$table->renameColumn('content', 'body');
				$table->dropColumn('meta_title');
				$table->dropColumn('meta_description');
				$table->dropColumn('meta_keywords');
			});
	}

}
