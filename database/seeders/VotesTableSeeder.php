<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vote;
use App\Models\Post;
use App\Models\User;

class VotesTableSeeder extends Seeder
{
    public function run()
    {
        // Get all posts and users
        $posts = Post::pluck('postId')->toArray();
        $users = User::pluck('id')->toArray();

        // Create 1000 random votes
        for ($i = 0; $i < 1000; $i++) {
            Vote::create([
                'post_id' => $posts[array_rand($posts)],
                'user_id' => $users[array_rand($users)],
                'vote_type' => rand(0, 1), // Randomly upvote or downvote
            ]);
        }
    }
}