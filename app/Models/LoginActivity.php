<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoginActivity extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'login_activities';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'company_id',
        'event',
        'occurred_at',
        'ip_address',
        'user_agent',
        'device',
        'location',
        'successful',
        'failure_reason',
        'metadata',
    ];

    protected $casts = [
        'occurred_at' => 'datetime',
        'successful' => 'boolean',
        'metadata' => 'array',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
