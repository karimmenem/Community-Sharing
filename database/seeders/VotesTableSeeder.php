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
        $posts = Post::pluck('postId')->toArray();
        $users = User::pluck('id')->toArray();

        // Create 1000 random votes
        Vote::factory()->count(1000)->create()->each(function ($vote) use ($posts, $users) {
            $vote->update([
                'post_id' => $posts[array_rand($posts)],
                'user_id' => $users[array_rand($users)],
                'vote_type' => rand(0, 1), // Random upvote/downvote
            ]);
        });
    }
}
