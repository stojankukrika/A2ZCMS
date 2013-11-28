<?php

class SettingsPermissionsTableSeeder extends Seeder {

	public function run() {
		DB::table('permissions') -> delete();

		$permissions = array( 
						array('name' => 'menage_todolists', 
						'display_name' => 'Manage todolists',1),
					);

		DB::table('permissions') -> insert($permissions);

		//DB::table('permission_role')->delete();

		$permissions = array( array('role_id' => 1, 'permission_id' => 16), );

		DB::table('permission_role') -> insert($permissions);
	}

}
