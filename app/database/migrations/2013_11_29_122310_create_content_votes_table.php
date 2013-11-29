<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContentVotesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('content_votes', function(Blueprint $table) {
			$table->increments('id');
			$table -> integer('user_id')->unsigned()->index();
			$table -> foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table -> boolean('updown');
			$table -> string('content');			
			$table -> integer('idcontent');		
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
		Schema::drop('content_votes');
	}

}
