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
        $users = User::pluck('id')->toArray();
        $categories = Category::pluck('id')->toArray(); // Ensure we're using `id` instead of `categoryId`

        // Create 500 fake posts and assign user_id and categoryId after creation
        Post::factory()->count(500)->create()->each(function ($post) use ($users, $categories) {
            $post->update([
                'user_id' => $users[array_rand($users)],
                'categoryId' => $categories[array_rand($categories)],
            ]);
        });
    }
}
