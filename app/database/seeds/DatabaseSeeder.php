<?php

class DatabaseSeeder extends Seeder {

	public function run() {
		Eloquent::unguard();

		// Add calls to Seeders here
		$this -> call('PermissionsTableSeeder');
		$this -> call('SettingsTableSeeder');
		$this -> call('NavPagesPermissionSeeder');
		$this -> call('GallerysPermissionSeeder');
		$this -> call('CustomFormPermissionsTableSeeder');
		$this -> call('PluginsTableSeeder');
		$this -> call('PluginfunctionTableSeeder');
		$this -> call('CustomFormsTableSeeder');
		$this -> call('CustomFormFieldsTableSeeder');
		$this -> call('NavigationGroupsTableSeeder');
		$this -> call('PagesTableSeeder');
		$this -> call('NavigationLinksTableSeeder');
		$this -> call('PagePluginFunctionsTableSeeder');
		$this -> call('SettingsPermissionsTableSeeder');
		$this -> call('ToDoListPermissionsTableSeeder');
	}

}
