<?php

class BlogCategorisTableSeeder extends Seeder {

	public function run() {
		// Uncomment the below to wipe the table clean before populating
		// DB::table('blogcategorys')->truncate();

		$blogcategorys = array( array('title' => 'Test 1', 'created_at' => new DateTime, 'updated_at' => new DateTime, ), array('title' => 'Test 2', 'created_at' => new DateTime, 'updated_at' => new DateTime, ), );

		// Uncomment the below to run the seeder
		DB::table('blog_categorys') -> insert($blogcategorys);
	}

}
