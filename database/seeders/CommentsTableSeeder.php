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
        $posts = Post::pluck('postId')->toArray(); // Ensure referencing `postId`
        $users = User::pluck('id')->toArray();

        // Create 1000 random comments
        Comment::factory()->count(1000)->create()->each(function ($comment) use ($posts, $users) {
            $comment->update([
                'post_id' => $posts[array_rand($posts)],
                'user_id' => $users[array_rand($users)],
            ]);
        });
    }
}
