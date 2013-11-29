<?php

class NavPagesPermissionSeeder extends Seeder {

	public function run() {

		$permissions = array( 
					array('name' => 'manage_navigation', 
							'display_name' => 'Manage navigation','is_admin' => 1), 
					array('name' => 'manage_pages', 
							'display_name' => 'Manage pages','is_admin' => 1), 
					array('name' => 'manage_navigation_groups', 
							'display_name' => 'Manage navigation groups','is_admin' => 1),
					);

		DB::table('permissions') -> insert($permissions);

		$permissions_role = array( 
								array('role_id' => 1, 'permission_id' => 7,'created_at' => new DateTime, 
						'updated_at' => new DateTime,), 
								array('role_id' => 1, 'permission_id' => 8,'created_at' => new DateTime, 
						'updated_at' => new DateTime,), 
								array('role_id' => 1, 'permission_id' => 9,'created_at' => new DateTime, 
						'updated_at' => new DateTime,));

		DB::table('permission_role') -> insert($permissions_role);
	}

}
