<?php

class PluginsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('plugins')->truncate();

		$plugins = array( 
					array('content' => 'Blog', 
						'function_id' => 'getBlogId',
						'function_grid' => 'getBlogGroupId',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ), 		
					array('content' => 'Gallery', 
						'function_id' => 'getGalleryId',
						'function_grid' => NULL,
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ), 
					array('content' => 'Custom form', 
						'function_id' => 'getCustomFormId',
						'function_grid' => NULL,
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ), 
					array('content' => 'To-do list', 
						'function_id' => NULL,
						'function_grid' => NULL,
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ), 
					array('content' => 'Pages', 
						'function_id' => NULL,
						'function_grid' => NULL,
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ), 
					array('content' => 'Blog', 
						'function_id' => NULL,
						'function_grid' => NULL,
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ), 
					array('content' => 'Settings', 
						'function_id' => NULL,
						'function_grid' => NULL,
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ), 
					array('content' => 'Users', 
						'function_id' => NULL,
						'function_grid' => NULL,
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ), 
						
				);

		// Uncomment the below to run the seeder
		 DB::table('plugins')->insert($plugins);
	}

}
