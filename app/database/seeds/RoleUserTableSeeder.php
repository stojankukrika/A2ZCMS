<?php

class RoleUserTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		 //DB::table('role_user')->truncate();

		$adminRole = Role::where('name','=','Admin')->first()->id;

        $userRole = Role::where('name','=','Registred user')->first()->id;

        $admin = User::where('username','=','admin')->first()->id;

        $user = User::where('username','=','user')->first()->id;
		
		$role_user = array(
							array('role_id' => $adminRole,'user_id'=>$admin,'active'=>1,'created_at' => new DateTime,
                					'updated_at' => new DateTime,),
               				array('role_id' => $userRole,'user_id'=>$user,'active'=>1,'created_at' => new DateTime,
                					'updated_at' => new DateTime,)
						);

		// Uncomment the below to run the seeder
		DB::table('role_user')->insert($role_user);
	}

}
