<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run()
    {
        $posts = Post::all();
        $users = User::all();

        $comments = [
            'Great post! Very informative.',
            'I learned a lot from this. Thanks!',
            'This is exactly what I was looking for.',
            'Could you elaborate more on this topic?',
            'I have a question regarding this part.',
            'This is a game-changer!',
            'I disagree with some points, but overall good post.',
            'Well written and easy to understand.',
            'Thanks for sharing this valuable information.',
            'This helped me solve my problem.',
            'I’m confused about one part. Can you clarify?',
            'This is a must-read for beginners.',
            'I’ve been looking for this for a long time!',
            'This post deserves more attention.',
            'I’ll definitely try this out.',
        ];

        foreach ($posts as $post) {
            $commentCount = rand(10, 15); // Each post will have 10-15 comments
            for ($i = 0; $i < $commentCount; $i++) {
                Comment::create([
                    'post_id' => $post->postId,
                    'user_id' => $users->random()->id,
                    'content' => $comments[array_rand($comments)], // Random comment from the list
                ]);
            }
        }
    }
}