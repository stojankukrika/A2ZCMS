<?php

class CustomFormPermissionsTableSeeder extends Seeder {

	public function run() {
			
		$permissions = array( 
						array('name' => 'manage_customform',
							'display_name' => 'Manage custom forms','is_admin' => 1),
					);

		DB::table('permissions') -> insert($permissions);

		//DB::table('permission_role')->delete();

		$permissions = array( array('role_id' => 1, 'permission_id' => 14) );

		DB::table('permission_role') -> insert($permissions);
	}

}
					