<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $primaryKey = 'voteId'; // Set the primary key
    public $incrementing = true; // Ensure primary key auto-increments
    protected $keyType = 'int'; // Set the primary key type

    protected $fillable = [
        'post_id',
        'user_id',
        'vote_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
