<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class VoteSeeder extends Seeder
{
    public function run()
    {
        $posts = Post::all();
        $users = User::all();

        foreach ($posts as $post) {
            $voteCount = rand(20, 30); // Each post will have 20-30 votes
            for ($i = 0; $i < $voteCount; $i++) {
                $voteType = rand(0, 1) ? true : false; // Randomly upvote or downvote
                $user = $users->random();

                // Ensure each user votes only once per post
                $existingVote = Vote::where('post_id', $post->postId)
                    ->where('user_id', $user->id)
                    ->first();

                if (!$existingVote) {
                    Vote::create([
                        'post_id' => $post->postId,
                        'user_id' => $user->id,
                        'vote_type' => $voteType,
                    ]);

                    // Update reputation points based on the vote
                    if ($voteType) {
                        $post->user->increment('reputationPoints', 1); // Upvote
                    } else {
                        $post->user->decrement('reputationPoints', 1); // Downvote
                    }
                }
            }
        }
    }
}