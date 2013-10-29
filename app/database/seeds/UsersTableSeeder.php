<?php

class UsersTableSeeder extends Seeder {

    public function run()
    {
        //DB::table('users')->delete();


        $users = array(
            array(
				'name' => 'Admin', 
				'surname' => 'User', 
                'username'      => 'admin',
                'email'      => 'admin@example.org',
                'password'   => Hash::make('admin'),
                'confirmed'   => 1,
				'active'=> 1,
                'confirmation_code' => md5(microtime().Config::get('app.key')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
				'name' => 'Registred', 
				'surname' => 'User', 
                'username'      => 'user',
                'email'      => 'user@example.org',
                'password'   => Hash::make('user'),
                'confirmed'   => 1,
				'active'=> 1,
                'confirmation_code' => md5(microtime().Config::get('app.key')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            )
        );

        DB::table('users')->insert( $users );
    }

}
