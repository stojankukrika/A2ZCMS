<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotBlogBlogCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blog_blog_categorys', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('blog_id')->unsigned()->index();
			$table->integer('blog_category_id')->unsigned()->index();
			$table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
			$table->foreign('blog_category_id')->references('id')->on('blog_categories')->onDelete('cascade');
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
		Schema::drop('blog_blog_categorys');
	}


}
