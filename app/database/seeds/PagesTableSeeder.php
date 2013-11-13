<?php

class PagesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('pages')->truncate();

		$pages = array( 
					array('name' => 'Home', 
						'slug' => 'home',
						'sidebar' => '1',
						'showtags' => '0',
						'showtitle' => '0',
						'showvote' => '0',
						'showdate' => '0',
						'voteup' => '0',
						'votedown' => '0',
						'password' => '',
						'tags' => '0',
						'hits' => '0',
						'content' => 'Welcome to A2ZCMS',
						'status' => '1',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, )	
						
				);
		// Uncomment the below to run the seeder
		 DB::table('pages')->insert($pages);
	}

}
