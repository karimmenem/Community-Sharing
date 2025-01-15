<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $primaryKey = 'postId'; // Specify the primary key
    public $incrementing = true; // Enable auto-increment for the primary key
    protected $keyType = 'int'; // Define the primary key type

    // Allow mass assignment for the specified attributes
    protected $fillable = [
        'user_id',
        'categoryId',
        'title',
        'description',
    ];

    /**
     * Relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id'); // Ensure proper foreign and local keys
    }

    /**
     * Relationship with the Category model.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId', 'categoryId'); // Use the correct primary key
    }

    /**
     * Relationship with the Comment model.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'postId'); // Ensure proper foreign and local keys
    }

    /**
     * Relationship with the Vote model.
     */
    public function votes()
    {
        return $this->hasMany(Vote::class, 'post_id', 'postId'); // Ensure proper foreign and local keys
    }
}
