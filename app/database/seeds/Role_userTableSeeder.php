<?php

class Role_userTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('role_user')->truncate();

		$role_user = array(
				 		array('role_id' => '1','user_id'=>'1','status'=>1,'created_at' => new DateTime,
                'updated_at' => new DateTime,),
              			array('role_id' => '2','user_id'=>'2','status'=>1,'created_at' => new DateTime,
                'updated_at' => new DateTime,)
				);

		// Uncomment the below to run the seeder
		 DB::table('role_user')->insert($role_user);
	}

}
