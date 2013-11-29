<?php

class PageVotePermissionsTableSeeder extends Seeder {

	public function run() {
			
		$permissions = array( 
						array('name' => 'post_page_vote', 
						'display_name' => 'Post page vote','is_admin' => 0),
						array('name' => 'post_blog_vote', 
						'display_name' => 'Post blog vote','is_admin' => 0),
						array('name' => 'post_image_vote', 
						'display_name' => 'Post image vote','is_admin' => 0),
					);

		DB::table('permissions') -> insert($permissions);

		//DB::table('permission_role')->delete();

		$permissions = array( array('role_id' => 1, 'permission_id' => 17,'created_at' => new DateTime, 
						'updated_at' => new DateTime,), 
						array('role_id' => 1, 'permission_id' => 18,'created_at' => new DateTime, 
						'updated_at' => new DateTime,),
						array('role_id' => 1, 'permission_id' => 19,'created_at' => new DateTime, 
						'updated_at' => new DateTime,),);

		DB::table('permission_role') -> insert($permissions);
	}

}
