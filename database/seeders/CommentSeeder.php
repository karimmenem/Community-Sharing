<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run()
    {
        // Get all post IDs
        $posts = Post::pluck('postId')->toArray();
        // Get all user IDs
        $users = User::pluck('id')->toArray();

        // Create 500 comments
        for ($i = 1; $i <= 500; $i++) {
            Comment::create([
                'post_id' => $posts[array_rand($posts)], // Random post
                'user_id' => $users[array_rand($users)], // Random user
                'content' => 'This is a comment on post ' . $posts[array_rand($posts)] . '.',
            ]);
        }
    }
}