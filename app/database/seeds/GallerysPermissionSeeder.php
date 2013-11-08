<?php

class GallerysPermissionSeeder extends Seeder {

	public function run() {

		$permissions = array( 
					array('name' => 'manage_galleries', 
							'display_name' => 'Manage galleries'), 
					array('name' => 'manage_gallery_images', 
							'display_name' => 'Manage gallery images'), 
					array('name' => 'manage_gallery_imagecomments', 
							'display_name' => 'Manage gallery image comments'));

		DB::table('permissions') -> insert($permissions);

		$permissions_role = array( 
								array('role_id' => 1, 'permission_id' => 10), 
								array('role_id' => 1, 'permission_id' => 11), 
								array('role_id' => 1, 'permission_id' => 12));

		DB::table('permission_role') -> insert($permissions_role);
	}

}

