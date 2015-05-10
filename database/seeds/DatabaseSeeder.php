<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use \App\User;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->seedUser();
	}

	public function seedUser()
	{
		User::create(['email' => 'erick.mo@vortege.com', 'password' => Hash::make('123123'), 'name' => 'Erick', 'is_registered' => true]);
	}

}
