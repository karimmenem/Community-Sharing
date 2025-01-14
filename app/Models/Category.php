<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'categoryId'; // Set the primary key to match your migration
    public $incrementing = true; // Ensure primary key auto-increments
    protected $keyType = 'int'; // Set the primary key type

    protected $fillable = [
        'name',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'categoryId');
    }
}
