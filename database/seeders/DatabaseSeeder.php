<?php

namespace Database\Seeders;

use App\Models\JobPost;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            JobPostSeeder::class
        ]);
    }
}