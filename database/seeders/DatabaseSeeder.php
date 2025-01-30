<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            CategorySeeder::class, // Seed categories first
            UserSeeder::class,
            PostSeeder::class,
            VoteSeeder::class,
            CommentSeeder::class,
        ]);
    }
}