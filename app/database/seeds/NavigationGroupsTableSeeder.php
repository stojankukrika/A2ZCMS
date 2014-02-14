<?php

class NavigationGroupsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('navigation_groups')->truncate();

		$navigation_groups = array( 
					array('title' => 'Main menu', 
						'slug' => 'main-menu',
						'showmenu' => '1',
						'showfooter' => '0',
						'showsidebar' => '0',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, )	
						
				);

		// Uncomment the below to run the seeder
		 DB::table('navigation_groups')->insert($navigation_groups);
	}

}
