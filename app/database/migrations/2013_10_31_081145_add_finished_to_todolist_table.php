<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFinishedToTodolistTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('todolist', function(Blueprint $table) {
			$table -> decimal('finished', 5, 2)->after('content');
			$table -> string('title')->after('user_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('todolist', function(Blueprint $table) {
			$table -> dropColumn('finished');
			$table -> dropColumn('title');
			
		});
	}

}
