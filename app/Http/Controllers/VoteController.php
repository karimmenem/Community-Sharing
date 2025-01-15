<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function vote(Request $request, Post $post, $type)
    {
        $user = Auth::user();

        // Ensure the user is authenticated
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to vote.');
        }

        // Determine vote type
        $voteType = $type === 'upvote';

        // Check if the user has already voted on this post
        $existingVote = Vote::where('post_id', $post->id)
                            ->where('user_id', $user->id)
                            ->first();

        if ($existingVote) {
            // If the same vote type is clicked again, remove the vote
            if ($existingVote->vote_type === $voteType) {
                $existingVote->delete();
                return back()->with('success', 'Your vote has been removed.');
            }

            // Otherwise, update the vote type
            $existingVote->update(['vote_type' => $voteType]);
            return back()->with('success', 'Your vote has been updated.');
        }

        // Create a new vote
        Vote::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'vote_type' => $voteType,
        ]);

        return back()->with('success', 'Your vote has been added.');
    }
}
