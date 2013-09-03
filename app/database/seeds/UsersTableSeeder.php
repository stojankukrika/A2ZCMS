<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		 //DB::table('users')->truncate();

			$users = array(
							array(
							    'name' => 'Admin', 'surname' => 'User', 'email'=> 'admin@a2zcms.com','picture'=> '0',
							    'username'=> 'admin','password'=> Hash::make('admin'),'active'=> '1','confirmed'=> '1',
								'confirmation_code'=>md5(microtime().Config::get('app.key')), 'created_at' => new DateTime,
							    'updated_at' => new DateTime,),
							
							
							array(
							    'name' => 'Registred', 'surname' => 'User', 'email'=> 'user@a2zcms.com','picture'=> '0',
							    'username'=> 'user','password'=> Hash::make('user'),'active'=> '1','confirmed'=> '1',
								'confirmation_code'=>md5(microtime().Config::get('app.key')), 'created_at' => new DateTime,
							    'updated_at' => new DateTime,)	
							);



		// Uncomment the below to run the seeder
		DB::table('users')->insert($users);
	}

}
