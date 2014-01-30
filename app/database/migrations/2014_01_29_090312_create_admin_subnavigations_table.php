<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminSubNavigationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_subnavigations', function(Blueprint $table) {
			$table->increments('id');
			$table -> integer('admin_navigation_id')->unsigned()->index();
			$table -> foreign('admin_navigation_id')->references('id')->on('admin_navigations')->onDelete('cascade');
			$table -> string('title');
			$table -> string('icon',50);
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
		Schema::drop('admin_subnavigations');
	}

}
