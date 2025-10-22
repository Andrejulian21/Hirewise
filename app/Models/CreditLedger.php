<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CreditLedger extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'credits_ledger';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'company_id',
        'subscription_id',
        'user_id',
        'type',
        'reason',
        'amount',
        'balance_after',
        'currency',
        'reference_id',
        'reference_type',
        'transaction_date',
        'status',
        'metadata',
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
        'metadata' => 'array',
    ];

    // Relaciones
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reference()
    {
        return $this->morphTo(__FUNCTION__, 'reference_type', 'reference_id');
    }
}
