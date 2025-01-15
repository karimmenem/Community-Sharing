<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $primaryKey = 'voteId'; // Primary key
    public $incrementing = true; // Auto-incrementing key
    protected $keyType = 'int'; // Integer primary key

    protected $fillable = [
        'post_id',
        'user_id',
        'vote_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'postId'); // Explicit foreign key and referenced key
    }
}
