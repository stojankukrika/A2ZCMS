<?php

class PluginsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('plugins')->truncate();

		$plugins = array( 
					array('content' => 'Blog', 
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ), 
		
					array('content' => 'Gallery', 
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ), 
				);

		// Uncomment the below to run the seeder
		 DB::table('plugins')->insert($plugins);
	}

}
