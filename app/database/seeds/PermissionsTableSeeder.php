<?php

class PermissionsTableSeeder extends Seeder {

	public function run() {
		DB::table('permissions') -> delete();

		$permissions = array( 
						array('name' => 'manage_blogs', 
						'display_name' => 'Manage blogs','is_admin' => 1), 
						array('name' => 'manage_blog_categris', 
						'display_name' => 'Manage blog categris','is_admin' => 1), 
						array('name' => 'manage_comments', 
						'display_name' => 'Manage comments','is_admin' => 1), 
						array('name' => 'manage_users', 
						'display_name' => 'Manage users','is_admin' => 1), 
						array('name' => 'manage_roles', 
						'display_name' => 'Manage roles','is_admin' => 1), 
						array('name' => 'post_blog_comment', 
						'display_name' => 'Post blog comment','is_admin' => 0), 
					);

		DB::table('permissions') -> insert($permissions);

		//DB::table('permission_role')->delete();

		$permissions = array( array('role_id' => 1, 'permission_id' => 1), 
								array('role_id' => 1, 'permission_id' => 2), 
								array('role_id' => 1, 'permission_id' => 3), 
								array('role_id' => 1, 'permission_id' => 4), 
								array('role_id' => 1, 'permission_id' => 5), 
								array('role_id' => 1, 'permission_id' => 6), );

		DB::table('permission_role') -> insert($permissions);
	}

}
