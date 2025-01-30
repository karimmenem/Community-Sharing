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

        // Create 200 posts
        for ($i = 1; $i <= 200; $i++) {
            Post::create([
                'user_id' => $users[array_rand($users)], // Random user
                'categoryId' => rand(1, 10), // Random category (1 to 10)
                'title' => 'Post Title ' . $i,
                'description' => 'This is the description for post ' . $i . '. It contains some details about the topic.',
            ]);
        }
    }
}