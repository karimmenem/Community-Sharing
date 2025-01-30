<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed categories first
        $this->call(CategoriesTableSeeder::class);

        // Seed users, posts, votes, and comments
        $this->call(UsersTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(VotesTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
    }
}