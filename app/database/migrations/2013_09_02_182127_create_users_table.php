<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('surname');
			$table->string('email')->unique();
			$table->boolean('picture')->default(false);
			$table->string('username')->unique();
			$table->string('password');
			$table->boolean('active')->default(false);
			$table->boolean('confirmed')->default(false);
			$table->string('confirmation_code');
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
		Schema::drop('users');
	}

}
