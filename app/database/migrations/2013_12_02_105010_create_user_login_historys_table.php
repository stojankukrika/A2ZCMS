<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserLoginHistorysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_login_historys', function(Blueprint $table) {
			$table->increments('id');
			$table -> integer('user_id')->unsigned()->index();
			$table -> foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
		Schema::drop('user_login_historys');
	}

}
