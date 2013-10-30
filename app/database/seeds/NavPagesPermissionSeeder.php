<?php

class NavPagesPermissionSeeder extends Seeder {

	public function run() {

		$permissions = array( array('name' => 'manage_navigation', 'display_name' => 'manage navigation'), array('name' => 'manage_pages', 'display_name' => 'manage pages'), array('name' => 'manage_navigation_groups', 'display_name' => 'Manage navigation groups'));

		DB::table('permissions') -> insert($permissions);

		$permissions_role = array( array('role_id' => 1, 'permission_id' => 7), array('role_id' => 1, 'permission_id' => 8), array('role_id' => 1, 'permission_id' => 9));

		DB::table('permission_role') -> insert($permissions_role);
	}

}
