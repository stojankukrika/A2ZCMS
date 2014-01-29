<?php

class AdminNavigationsTableSeeder extends Seeder {

	public function run() {
		// Uncomment the below to wipe the table clean before populating
		// DB::table('settings')->truncate();

		DB::table('admin_navigations') -> insert(array( 
											array('plugin_id' => 4, 
												'title' => 'To-do list', 
												'navigation' => 'todolists', 
												'order' => 1,
												'created_at' => new DateTime, 
												'updated_at' => new DateTime,), 
											array('plugin_id' => 3, 
												'title' => 'Custom forms', 
												'navigation' => 'customform', 
												'order' => 2,
												'created_at' => new DateTime, 
												'updated_at' => new DateTime,), 
											array('plugin_id' => 5, 
												'title' => 'Pages', 
												'navigation' => 'pages', 
												'order' => 3,
												'created_at' => new DateTime, 
												'updated_at' => new DateTime,), 
											array('plugin_id' => 1, 
												'title' => 'Blog', 
												'navigation' => 'blogcategorys', 
												'order' => 4,
												'created_at' => new DateTime, 
												'updated_at' => new DateTime,), 
											array('plugin_id' =>2, 
												'title' => 'Gallery', 
												'navigation' => 'gallery', 
												'order' => 5,
												'created_at' => new DateTime, 
												'updated_at' => new DateTime,), 
											array('plugin_id' => 7, 
												'title' => 'Users', 
												'navigation' => 'users', 
												'order' => 6,
												'created_at' => new DateTime, 
												'updated_at' => new DateTime,), 
											array('plugin_id' => 6, 
												'title' => 'Settings', 
												'navigation' => 'settings', 
												'order' => 7,
												'created_at' => new DateTime, 
												'updated_at' => new DateTime,), 
										)
									);

	}

}
