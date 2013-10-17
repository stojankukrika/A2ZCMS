<?php

class GalleryCategoriesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('gallerycategories')->truncate();

		$gallerycategories = array(
							    'title' => 'Gallery category 1', 'created_at' => new DateTime,
							    'updated_at' => new DateTime);

		// Uncomment the below to run the seeder
		 DB::table('gallery_categorys')->insert($gallerycategories);
	}

}
