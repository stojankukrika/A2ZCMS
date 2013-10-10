<?php

class SettingsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('settings')->truncate();

		DB::table('settings')->insert( array(
            array(
                'varname'    => 'updatetime',
				'groupname' => 'version',
                'value'      => '1381296823',
                'defaultvalue'       => '1381296823',
                'type' => 'text',		
            ),
            array(
               'varname'    => 'offline',
				'groupname' => 'general',
                'value'      => '0',
                'defaultvalue'       => '0',
                'type' => 'bool',	
            ),
            array(
               'varname'    => 'version',
				'groupname' => 'version',
                'value'      => '0.1',
                'defaultvalue'       => '0.1',
				'type' => 'text',		
            ),
			 array(
               'varname'    => 'offlinemessage',
				'groupname' => 'general',
                'value'      => '<p>Sorry, the site is unavailable at the moment while we are testing some functionality.</p>',
                'defaultvalue'       => 'Sorry, the site is unavailable at the moment while we are testing some functionality.',
				'type' => 'textarea',	
            ),
			 array(
               'varname'    => 'title',
				'groupname' => 'general',
                'value'      => 'A2Z CMS',
                'defaultvalue'       => 'A2Z CMS',
                'type' => 'text',		
            ),
			 array(
               'varname'    => 'copyright',
				'groupname' => 'general',
                'value'      => 'yoursite.com &copy; 2013',
                'defaultvalue'       => 'A2Z CMS 2013',
                'type' => 'text',	
            ),		
			 array(
               'varname'    => 'metadesc',
				'groupname' => 'general',
                'value'      => '',
                'defaultvalue'       => '',
                'type' => 'textarea',		
            ),
			 array(
               'varname'    => 'metakey',
				'groupname' => 'general',
                'value'      => '',
                'defaultvalue'       => '',
                'type' => 'text',		
            ),
			 array(
               'varname'    => 'metaauthor',
				'groupname' => 'general',
                'value'      => 'http://www.yoursite.com',
                'defaultvalue'       => 'http://www.a2zcms.com',
                'type' => 'text',		
            ),
			 array(
               'varname'    => 'analytics',
				'groupname' => 'general',
                'value'      => '',
                'defaultvalue'       => '',
                'type' => 'textarea',	
            ),
			 array(
               'varname'    => 'email',
				'groupname' => 'setting',
                'value'      => 'admin@example.com',
                'defaultvalue'       => '',
                'type' => 'text',		
            ),
			 array(
               'varname'    => 'dateformat',
				'groupname' => 'setting',
                'value'      => 'd.m.Y',
                'defaultvalue'       => 'd.m.Y',
                'type' => 'text',		
            ),
			 array(
               'varname'    => 'timeformat',
				'groupname' => 'setting',
                'value'      => ' - H:i',
                'defaultvalue'       => 'h:i A',
                'type' => 'text',	
            ),
			 array(
               'varname'    => 'useravatwidth',
				'groupname' => 'setting',
                'value'      => '150',
                'defaultvalue'       => '150',
                'type' => 'text',	
            ),
			 array(
               'varname'    => 'useravatheight',
				'groupname' => 'setting',
                'value'      => '113',
                'defaultvalue'       => '113',
                'type' => 'text',	
            ),
			 array(
               'varname'    => 'shortmsg',
				'groupname' => 'setting',
                'value'      => '300',
                'defaultvalue'       => '300',
                'type' => 'text',		
            ),
			array(
               'varname'    => 'pageitem',
				'groupname' => 'setting',
                'value'      => '15',
                'defaultvalue'       => '15',
                'type' => 'text',	
            ),
			
			)
        );
		
	}

}
