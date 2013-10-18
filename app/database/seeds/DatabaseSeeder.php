<?php

class DatabaseSeeder extends Seeder {

    public function run()
    {
        Eloquent::unguard();

        // Add calls to Seeders here
        $this->call('UsersTableSeeder');		
        $this->call('RolesTableSeeder');		
        $this->call('PermissionsTableSeeder');
		$this->call('BlogCategorisTableSeeder');
        $this->call('BlogsTableSeeder');
        $this->call('BlogCommentsTableSeeder');
    	$this->call('SettingsTableSeeder');
    	$this->call('NavPagesPermissionSeeder'); 
		$this->call('GallerysTableSeeder');
		$this->call('GalleryCommentsTableSeeder');
	}

}