<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'name',
        'description',
        'discount_type',
        'discount_value',
        'currency',
        'max_uses',
        'uses_per_company',
        'used_count',
        'is_active',
        'starts_at',
        'expires_at',
        'plan_id',
        'metadata',
    ];

    protected $casts = [
        'discount_value' => 'float',
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'metadata' => 'array',
    ];

    // Relaciones
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
