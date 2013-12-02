<?php

class NavigationLinksTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('navigation_links')->truncate();
		$page_id = Page::first()->id;
		$navigation_group_id = NavigationGroup::first()->id;
		
		$navigation_links = array( 
					array('title' => 'Home', 
						'parent' => NULL,
						'link_type' => 'page',
						'page_id' => $page_id,
						'url' => '',
						'uri' => '',
						'navigation_group_id' => $navigation_group_id,
						'position' => '1',
						'target' => '',
						'restricted_to' => '',
						'class' => '',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, )							
				);

		// Uncomment the below to run the seeder
		 DB::table('navigation_links')->insert($navigation_links);
	}

}
