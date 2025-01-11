<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'categoryId',
        'title',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'postId');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'postId');
    }
}
