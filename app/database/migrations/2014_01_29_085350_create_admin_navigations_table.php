<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminNavigationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_navigations', function(Blueprint $table) {
			$table->increments('id');
			$table -> integer('plugin_id')->unsigned()->index();
			$table -> foreign('plugin_id')->references('id')->on('plugins')->onDelete('cascade');
			$table -> string('title');
			$table -> string('url');			
			$table -> integer('order');		
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
		Schema::drop('admin_navigations');
	}

}
