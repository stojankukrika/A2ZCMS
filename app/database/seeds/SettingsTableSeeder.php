<?php

class SettingsTableSeeder extends Seeder {

	public function run() {
		// Uncomment the below to wipe the table clean before populating
		// DB::table('settings')->truncate();

		DB::table('settings') -> insert(array( 
											array('varname' => 'updatetime', 
												'groupname' => 'version', 
												'value' => time(), 
												'defaultvalue' => time(), ), 
											array('varname' => 'offline', 
												'groupname' => 'general', 
												'value' => '0', 
												'defaultvalue' => '0', ), 
											array('varname' => 'version', 
												'groupname' => 'version', 
												'value' => '1.0', 
												'defaultvalue' => '1.0', ), 
											array('varname' => 'offlinemessage', 
												'groupname' => 'general', 
												'value' => '<p>Sorry, the site is unavailable at the moment while we are testing some functionality.</p>', 
												'defaultvalue' => 'Sorry, the site is unavailable at the moment while we are testing some functionality.', ), 
											array('varname' => 'title', 
												'groupname' => 'general', 
												'value' => 'A2Z CMS', 
												'defaultvalue' => 'A2Z CMS', ), 
											array('varname' => 'copyright', 
												'groupname' => 'general', 
												'value' => 'yoursite.com &copy; 2013', 
												'defaultvalue' => 'A2Z CMS 2013', ), 
											array('varname' => 'metadesc', 
												'groupname' => 'general', 
												'value' => '', 
												'defaultvalue' => '', ), 
											array('varname' => 'metakey', 
												'groupname' => 'general', 
												'value' => '', 
												'defaultvalue' => '', ), 
											array('varname' => 'metaauthor', 
												'groupname' => 'general', 
												'value' => 'http://www.yoursite.com', 
												'defaultvalue' => 'http://www.a2zcms.com', ), 
											array('varname' => 'analytics', 
												'groupname' => 'general', 
												'value' => '', 
												'defaultvalue' => '', ), 
											array('varname' => 'email', 
												'groupname' => 'setting', 
												'value' => 'admin@example.com', 
												'defaultvalue' => '', ), 
											array('varname' => 'dateformat', 
												'groupname' => 'setting', 
												'value' => 'd.m.Y', 
												'defaultvalue' => 'd.m.Y', ), 
											array('varname' => 'timeformat', 
												'groupname' => 'setting', 
												'value' => ' - H:i', 
												'defaultvalue' => 'h:i A', ), 
											array('varname' => 'useravatwidth', 
												'groupname' => 'setting', 
												'value' => '150', 
												'defaultvalue' => '150', ), 
											array('varname' => 'useravatheight', 
												'groupname' => 'setting', 
												'value' => '113', 
												'defaultvalue' => '113', ), 
											array('varname' => 'pageitem', 
												'groupname' => 'setting', 
												'value' => '15', 
												'defaultvalue' => '15', ), 
											array('varname' => 'searchcode', 
												'groupname' => 'setting', 
												'value' => '', 
												'defaultvalue' => '', ), 
											array('varname' => 'sitetheme', 
												'groupname' => 'setting', 
												'value' => '', 
												'defaultvalue' => 'default', ),
										)
									);

	}

}
