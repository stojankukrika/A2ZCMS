<?php

class PagesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('pages')->truncate();
		$ontent = '<div><h1>A2Z CMS 1.0</h1><p>Welcome to your very own A2Z CMS 1.1 installation.</p></div><div><p>Login into your profile and change this page and enjoy in A2ZCMS.</p><p>If you have any questions feel free to check the <a href="https://github.com/mrakodol/A2ZCMS/issues">Issues</a> at any time or create a new issue.</p><p>Enjoy A2Z CMS and welcome a board.</p><p>Kind Regards</p><p>Stojan Kukrika - A2Z CMS</p></div>';
		$pages = array( 
					array('name' => 'Home', 
						'slug' => 'home',
						'sidebar' => '1',
						'showtags' => '1',
						'showtitle' => '1',
						'showvote' => '1',
						'showdate' => '1',
						'voteup' => '0',
						'votedown' => '0',
						'password' => '',
						'tags' => 'tag1',
						'hits' => '0',
						'content' => $ontent,
						'status' => '1',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, )	
						
				);
		// Uncomment the below to run the seeder
		 DB::table('pages')->insert($pages);
	}

}
