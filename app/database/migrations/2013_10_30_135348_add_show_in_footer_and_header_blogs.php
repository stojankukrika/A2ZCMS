<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddShowInFooterAndHeaderBlogs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('navigation_groups', function(Blueprint $table) {
			$table -> boolean('showmenu')->after('slug');
			$table -> boolean('showfooter')->after('showmenu');
			$table -> boolean('showsidebar')->after('showfooter');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('navigation_groups', function(Blueprint $table) {
			$table -> dropColumn('showmenu');
			$table -> dropColumn('showfooter');
			$table -> dropColumn('showsidebar');

		});
	}

}
