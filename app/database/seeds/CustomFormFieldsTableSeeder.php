<?php

class CustomFormFieldsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('contact_form_fields')->truncate();
		$custom_forms = CustomForm::find(1) -> id;
		$user_id = User::first() -> id;
		
		$custom_form_fields = array( 
					array(
						'custom_page_id'=>$custom_forms,
						'user_id' => $user_id,
						'title' => 'Name', 
						'options' => '',
						'typeid' => '1',
						'order' => '1',
						'mandatory' => '1',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, ),
					array(
						'custom_page_id'=>$custom_forms,
						'user_id' => $user_id,
						'title' => 'Email', 
						'options' => '',
						'typeid' => '1',
						'order' => '2',
						'mandatory' => '3',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, )	,
					array(
						'custom_page_id'=>$custom_forms,
						'user_id' => $user_id,
						'title' => 'Phone', 
						'options' => '',
						'typeid' => '1',
						'order' => '3',
						'mandatory' => '2',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, )	,
					array(
						'custom_page_id'=>$custom_forms,
						'user_id' => $user_id,
						'title' => 'Message', 
						'options' => '',
						'typeid' => '2',
						'order' => '4',
						'mandatory' => '1',
						'created_at' => new DateTime, 
						'updated_at' => new DateTime, )							
			);

		// Uncomment the below to run the seeder
		 DB::table('custom_form_fields')->insert($custom_form_fields);
	}

}
