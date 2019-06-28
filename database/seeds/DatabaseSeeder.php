<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'name' => 'admin',
        	'email' => 'admin@gmail.com',
        	'password' =>bcrypt('178SAurabh'),
        	'user_type' =>'admin'
        ]);
    }
}
