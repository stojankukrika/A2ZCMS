<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotPagePluginFunctionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('page_plugin_functions', function(Blueprint $table) {
			$table -> increments('id');
			$table -> integer('page_id')->unsigned()->index();
			$table -> integer('plugin_function_id')->unsigned()->index();
			$table -> foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
			$table -> foreign('plugin_function_id')->references('id')->on('plugin_functions')->onDelete('cascade');
			$table -> integer('order');
			$table -> string('param');
			$table -> string('type');
			$table -> string('value');	
			$table -> timestamps();
			$table -> softDeletes();
		});
	}



	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('page_plugin_functions');
	}

}
