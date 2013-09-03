<?php

class RolesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('roles')->truncate();

		$roles = array(
		 array(
             'name' => 'Admin', 'created_at' => new DateTime,
                'updated_at' => new DateTime,),
		 array(
             'name' => 'Registred user', 'created_at' => new DateTime,
                'updated_at' => new DateTime,)			 
		);
		// Uncomment the below to run the seeder
		 DB::table('roles')->insert($roles);
	}

}
