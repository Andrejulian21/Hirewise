<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'company_id',
        'plan_id',
        'provider',
        'provider_subscription_id',
        'status',
        'starts_at',
        'ends_at',
        'trial_ends_at',
        'features',
        'limits',
        'auto_renew',
        'amount_usd',
        'currency',
        'billing_cycle',
        'last_billed_at',
        'next_billing_at',
    ];

    protected $casts = [
        'features' => 'array',
        'limits' => 'array',
        'auto_renew' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'last_billed_at' => 'datetime',
        'next_billing_at' => 'datetime',
    ];

    // Relaciones
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
