<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        $posts = [
            [
                'user_id' => $users->random()->id,
                'categoryId' => 1,
                'title' => 'Mastering Laravel Relationships',
                'description' => 'Learn how to effectively use Eloquent relationships in Laravel.',
            ],
            [
                'user_id' => $users->random()->id,
                'categoryId' => 2,
                'title' => 'Vue.js Composition API Guide',
                'description' => 'A comprehensive guide to using the Composition API in Vue.js.',
            ],
            [
                'user_id' => $users->random()->id,
                'categoryId' => 3,
                'title' => 'Building Scalable REST APIs',
                'description' => 'Best practices for designing and building scalable REST APIs.',
            ],
            [
                'user_id' => $users->random()->id,
                'categoryId' => 1,
                'title' => 'Laravel Queues and Jobs',
                'description' => 'How to use queues and jobs in Laravel for background processing.',
            ],
            [
                'user_id' => $users->random()->id,
                'categoryId' => 2,
                'title' => 'Vue.js Performance Optimization',
                'description' => 'Tips and tricks for optimizing the performance of Vue.js applications.',
            ],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}