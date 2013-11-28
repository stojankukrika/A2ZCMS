<?php

class ToDoListPermissionsTableSeeder extends Seeder {

	public function run() {
			
		$permissions = array( 
						array('name' => 'manage_todolists', 
						'display_name' => 'Manage todolists','is_admin' => 1),
					);

		DB::table('permissions') -> insert($permissions);

		//DB::table('permission_role')->delete();

		$permissions = array( array('role_id' => 1, 'permission_id' => 16), );

		DB::table('permission_role') -> insert($permissions);
	}

}
