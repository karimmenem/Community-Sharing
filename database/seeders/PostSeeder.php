<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        // Get all user IDs
        $users = User::pluck('id')->toArray();

        // Create 500 posts
        for ($i = 1; $i <= 500; $i++) {
            Post::create([
                'user_id' => $users[array_rand($users)], // Random user
                'categoryId' => rand(1, 10), // Random category (assuming 10 categories exist)
                'title' => 'Post Title ' . $i,
                'description' => 'This is the description for post ' . $i,
            ]);
        }
    }
}