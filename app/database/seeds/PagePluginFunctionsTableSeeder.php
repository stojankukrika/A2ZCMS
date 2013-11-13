<?php

class PagePluginFunctionsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('page_plugin_functions')->truncate();
		
		$page_id = Page::first()->id;
		$plugin_function_id = PluginFunction::find(5)->id;
		$page_plugin_functions = array( 
					array('page_id' => $page_id, 
						'plugin_function_id' => $plugin_function_id,
						'order' => '1',
						'param' => '',
						'type' => '',
						'value' => '',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, )	
						
				);
		

		// Uncomment the below to run the seeder
		DB::table('page_plugin_functions')->insert($page_plugin_functions);
	}

}
