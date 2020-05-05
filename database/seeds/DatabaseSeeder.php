<?php

use Illuminate\Database\Seeder;
use \App\User;
use \Illuminate\Support\Facades\Hash;
use \Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
           'name' => 'Manager',
           'email' => 'manager@manager.ru',
           'password' => Hash::make('qwer1234'),
            'role' => 1,
            'created_at' => Carbon::now(),
        ]);
    }
}
