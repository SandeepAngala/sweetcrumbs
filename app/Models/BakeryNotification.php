<?php

namespace App\Models;

use Illuminate\Notifications\DatabaseNotification as BaseDatabaseNotification;
use MongoDB\Laravel\Eloquent\DocumentModel;

class BakeryNotification extends BaseDatabaseNotification
{
    use DocumentModel;

    protected $connection = 'mongodb';
    protected $collection = 'bakery_notifications';
    protected $table = 'bakery_notifications';

    protected $fillable = ['user_id', 'type', 'title', 'message', 'data', 'read_at'];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->user_id) && !empty($model->notifiable_id)) {
                $model->user_id = $model->notifiable_id;
            }
        });
    }

    public function getTitleAttribute()
    {
        return $this->data['title'] ?? ($this->attributes['title'] ?? '');
    }

    public function getMessageAttribute()
    {
        return $this->data['message'] ?? ($this->attributes['message'] ?? '');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

