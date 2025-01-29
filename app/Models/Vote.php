<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $primaryKey = 'voteId'; // Match the migration
    protected $fillable = ['post_id', 'user_id', 'vote_type'];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'postId');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}