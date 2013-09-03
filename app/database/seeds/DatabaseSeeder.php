<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		$this->call('UsersTableSeeder');
		$this->call('RolesTableSeeder');
		$this->call('Password_remaindersTableSeeder');
		$this->call('PrivilagesTableSeeder');
		$this->call('RoleUserTableSeeder');
	}

}