<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $primaryKey = 'postId'; // Primary key
    public $incrementing = true; // Auto-incrementing key
    protected $keyType = 'int'; // Integer primary key

    protected $fillable = [
        'user_id',
        'categoryId',
        'title',
        'description',
    ];

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
}
