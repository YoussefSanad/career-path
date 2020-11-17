<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'     => 'Admin',
            'email'    => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'admin'    => 1
        ]);

        DB::table('users')->insert([
            'name'     => 'User',
            'email'    => 'user@gmail.com',
            'password' => bcrypt('user'),
            'admin'    => 0
        ]);
    }
}
