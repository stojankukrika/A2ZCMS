<?php

class CustomFormsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('contact_forms')->truncate();
		$user_id = User::first();
		
		$custom_forms = array( 
					array('title' => 'Standard contact form', 
						'user_id' => $user_id -> id,
						'recievers' => $user_id -> email,
						'message' => '<p>Thank you for contact us, we will get back to you as soon as we can.</p>',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ));

		// Uncomment the below to run the seeder
		DB::table('custom_forms')->insert($custom_forms);
	}

}
