<?php

class GallerysTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('gallerys')->truncate();
		
		$user_id = User::first()->id;
		$galleryscategory = GalleryCategory::find(1)->id;

		$gallerys = array(
								array(
								'gallerycategory_id' =>$galleryscategory,
								'user_id' => $user_id,
							    'title' => 'Gallery 1', 
								'created_at' => new DateTime,
							    'updated_at' => new DateTime,
								'start_publish' => new DateTime,),
		);

		// Uncomment the below to run the seeder
		 DB::table('gallery')->insert($gallerys);
	}

}
