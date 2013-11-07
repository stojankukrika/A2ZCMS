<?php

class GridsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('grids')->truncate();
		$plugin_id1 = Plugin::find(1) -> id;
		$plugin_id2 = Plugin::find(2) -> id;
		
		$grids = array( 
					array('plugin_id'=>$plugin_id1,
						'order' => 1, 
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ), 
		
					array('plugin_id'=>$plugin_id2,
						'order' => 2, 
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ), 
				);

		// Uncomment the below to run the seeder
		 DB::table('grids')->insert($grids);
	}

}
