<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $primaryKey = 'postId';
    protected $fillable = [
        'user_id',
        'categoryId',
        'title',
        'description',
        'image' // Add this line
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId', 'categoryId');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'post_id', 'postId');
    }

    // Add this missing relationship
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'postId');
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}