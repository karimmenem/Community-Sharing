<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $primaryKey = 'postId'; // Set the primary key
    public $incrementing = true; // Ensure primary key auto-increments
    protected $keyType = 'int'; // Set the primary key type

    protected $fillable = [
        'user_id',
        'categoryId',
        'title',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'post_id');
    }
}
