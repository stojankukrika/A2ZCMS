<?php

class GallerysPermissionSeeder extends Seeder {

	public function run() {

		$permissions = array( 
					array('name' => 'manage_galleries', 
							'display_name' => 'Manage galleries','is_admin' => 1), 
					array('name' => 'manage_gallery_images', 
							'display_name' => 'Manage gallery images','is_admin' => 1), 
					array('name' => 'manage_gallery_imagecomments', 
							'display_name' => 'Manage gallery image comments','is_admin' => 1),
					array ('name' => 'post_gallery_comment' ,
							'display_name' => 'Post gallery comment','is_admin' => 0));

		DB::table('permissions') -> insert($permissions);

		$permissions_role = array( 
								array('role_id' => 1, 'permission_id' => 10,'created_at' => new DateTime, 
						'updated_at' => new DateTime,), 
								array('role_id' => 1, 'permission_id' => 11,'created_at' => new DateTime, 
						'updated_at' => new DateTime,), 
								array('role_id' => 1, 'permission_id' => 12,'created_at' => new DateTime, 
						'updated_at' => new DateTime,),
								array('role_id' => 1, 'permission_id' => 13,'created_at' => new DateTime, 
						'updated_at' => new DateTime,));

		DB::table('permission_role') -> insert($permissions_role);
	}

}

