<?php

class AdminNavigationsTableSeeder extends Seeder {

	public function run() {
		// Uncomment the below to wipe the table clean before populating
		// DB::table('settings')->truncate();

		DB::table('admin_navigations') -> insert(array( 
											array('plugin_id' => 4, 
												'title' => 'To-do list',
												'icon' =>'icon-bell', 
												'url' => 'todolists', 
												'order' => 1,
												'created_at' => new DateTime, 
												'updated_at' => new DateTime,), 
											array('plugin_id' => 3, 
												'title' => 'Custom forms', 
												'icon' =>'icon-list-alt',
												'url' => 'customform', 
												'order' => 2,
												'created_at' => new DateTime, 
												'updated_at' => new DateTime,), 
											array('plugin_id' => 5, 
												'title' => 'Pages',
												'icon' =>'icon-globe', 
												'url' => 'pages', 
												'order' => 3,
												'created_at' => new DateTime, 
												'updated_at' => new DateTime,), 
											array('plugin_id' => 1, 
												'title' => 'Blog', 
												'icon' =>'icon-external-link',
												'url' => 'blogcategorys', 
												'order' => 4,
												'created_at' => new DateTime, 
												'updated_at' => new DateTime,), 
											array('plugin_id' =>2, 
												'title' => 'Gallery',
												'icon' =>'icon-camera', 
												'url' => 'gallery', 
												'order' => 5,
												'created_at' => new DateTime, 
												'updated_at' => new DateTime,), 
											array('plugin_id' => 7, 
												'title' => 'Users', 
												'icon' =>'icon-group',
												'url' => 'users', 
												'order' => 6,
												'created_at' => new DateTime, 
												'updated_at' => new DateTime,), 
											array('plugin_id' => 6, 
												'title' => 'Settings', 
												'icon' =>'icon-cogs',
												'url' => 'settings', 
												'order' => 7,
												'created_at' => new DateTime, 
												'updated_at' => new DateTime,), 
										)
									);

	}

}
