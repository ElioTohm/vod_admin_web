<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@shareeftube.com',
            'password' => bcrypt('123123'),
        ]);
    }
}
