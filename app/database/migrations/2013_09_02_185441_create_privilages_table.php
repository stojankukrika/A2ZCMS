<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePrivilagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('privilages', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('resource');
			$table->boolean('view')->default(false);
			$table->boolean('edit')->default(false);
			$table->boolean('delete')->default(false);
			$table->boolean('insert')->default(false);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('privilages');
	}

}
