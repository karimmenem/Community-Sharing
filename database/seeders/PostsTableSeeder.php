<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        // Get all user IDs
        $users = User::pluck('id')->toArray();

        // Get all category IDs
        $categories = Category::pluck('categoryId')->toArray();

        // Create 500 fake posts
        Post::factory()->count(500)->create([
            'user_id' => function () use ($users) {
                return $users[array_rand($users)];
            },
            'categoryId' => function () use ($categories) {
                return $categories[array_rand($categories)];
            },
        ]);
    }
}