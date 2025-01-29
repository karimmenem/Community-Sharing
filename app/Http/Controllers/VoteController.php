<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Post;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function upvote(Post $post)
    {
        $existingVote = $post->votes()->where('user_id', auth()->id())->first();

        if ($existingVote) {
            if ($existingVote->vote_type === false) {
                $existingVote->update(['vote_type' => true]);
                $post->user->increment('reputationPoints', 2); // +2 for changing to upvote
            }
        } else {
            $post->votes()->create([
                'user_id' => auth()->id(),
                'vote_type' => true,
            ]);
            $post->user->increment('reputationPoints', 1); // +1 for new upvote
        }

        return back();
    }

    public function downvote(Post $post)
    {
        $existingVote = $post->votes()->where('user_id', auth()->id())->first();

        if ($existingVote) {
            if ($existingVote->vote_type === true) {
                $existingVote->update(['vote_type' => false]);
                $post->user->decrement('reputationPoints', 1); // -1 for changing to downvote
            }
        } else {
            $post->votes()->create([
                'user_id' => auth()->id(),
                'vote_type' => false,
            ]);
            $post->user->decrement('reputationPoints', 1); // -1 for new downvote
        }

        return back();
    }

    public function removeVote(Post $post)
    {
        $existingVote = $post->votes()->where('user_id', auth()->id())->first();

        if ($existingVote) {
            if ($existingVote->vote_type === true) {
                $post->user->decrement('reputationPoints', 1); // -1 for removing upvote
            } else {
                $post->user->increment('reputationPoints', 1); // +1 for removing downvote
            }
            $existingVote->delete();
        }

        return back();
    }
}