<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Vote;
use App\Models\User;
use Illuminate\Database\Seeder;

class VoteSeeder extends Seeder
{
    public function run()
    {
        // Get all post IDs
        $posts = Post::pluck('postId')->toArray();
        // Get all user IDs
        $users = User::pluck('id')->toArray();

        // Create 2000 votes
        for ($i = 1; $i <= 2000; $i++) {
            Vote::create([
                'post_id' => $posts[array_rand($posts)], // Random post
                'user_id' => $users[array_rand($users)], // Random user
                'vote_type' => (bool) rand(0, 1), // Random vote type (true = upvote, false = downvote)
            ]);
        }
    }
}