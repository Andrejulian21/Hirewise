<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'code',
        'description',
        'features',
        'limits',
        'price_usd',
        'currency',
        'billing_cycle',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'features' => 'array',
        'limits' => 'array',
        'is_active' => 'boolean',
    ];

    // Relaciones
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
