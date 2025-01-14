<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $primaryKey = 'notification_id'; // Set the primary key
    public $incrementing = true; // Ensure primary key auto-increments
    protected $keyType = 'int'; // Set the primary key type

    protected $fillable = [
        'user_id',
        'message',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
