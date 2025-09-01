<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'seen',
        'created_at',
        'receive_time',
        'notification_expiry_date',
    ];

    protected $casts = [
        'seen' => 'boolean',
        'created_at' => 'datetime',
        'receive_time' => 'datetime',
        'notification_expiry_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
