<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notifications';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'company_id',
        'user_id',
        'type',
        'channel',
        'title',
        'message',
        'data',
        'link',
        'is_read',
        'is_delivered',
        'delivered_at',
        'read_at',
        'priority',
        'expires_at',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'is_delivered' => 'boolean',
        'delivered_at' => 'datetime',
        'read_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // Relaciones
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helpers
    public function markAsRead(): void
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    public function markAsDelivered(): void
    {
        $this->update([
            'is_delivered' => true,
            'delivered_at' => now(),
        ]);
    }
}
