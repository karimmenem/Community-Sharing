<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentsTableSeeder extends Seeder
{
    public function run()
    {
        // Get all posts and users
        $posts = Post::pluck('postId')->toArray();
        $users = User::pluck('id')->toArray();

        // Create 1000 random comments
        for ($i = 0; $i < 1000; $i++) {
            Comment::create([
                'post_id' => $posts[array_rand($posts)],
                'user_id' => $users[array_rand($users)],
                'content' => 'This is a random comment.',
            ]);
        }
    }
}