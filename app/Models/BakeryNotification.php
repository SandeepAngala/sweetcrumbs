<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class BakeryNotification extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'bakery_notifications';

    protected $fillable = ['user_id', 'type', 'title', 'message', 'data', 'read_at'];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
