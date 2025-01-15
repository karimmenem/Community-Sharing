<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Post;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function upvote(Post $post)
    {
        // Check if user has already voted
        $existingVote = $post->votes()->where('user_id', auth()->id())->first();

        if ($existingVote) {
            // If already voted, check if it's an upvote or downvote and adjust accordingly
            if ($existingVote->vote_type === false) {
                // Change from downvote to upvote
                $existingVote->update(['vote_type' => true]);
            }
            return back();
        }

        // Create a new upvote
        $post->votes()->create([
            'user_id' => auth()->id(),
            'vote_type' => true,
        ]);

        return back();
    }

    public function downvote(Post $post)
    {
        // Check if user has already voted
        $existingVote = $post->votes()->where('user_id', auth()->id())->first();

        if ($existingVote) {
            // If already voted, check if it's an upvote or downvote and adjust accordingly
            if ($existingVote->vote_type === true) {
                // Change from upvote to downvote
                $existingVote->update(['vote_type' => false]);
            }
            return back();
        }

        // Create a new downvote
        $post->votes()->create([
            'user_id' => auth()->id(),
            'vote_type' => false,
        ]);

        return back();
    }

    public function removeVote(Post $post)
    {
        // Find the existing vote by the user
        $existingVote = $post->votes()->where('user_id', auth()->id())->first();

        if ($existingVote) {
            $existingVote->delete();
        }

        return back();
    }
}
