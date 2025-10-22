<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Webhook extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'webhooks';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'company_id',
        'name',
        'endpoint_url',
        'events',
        'secret_token',
        'is_active',
        'success_count',
        'failure_count',
        'last_triggered_at',
        'last_failed_at',
    ];

    protected $casts = [
        'events' => 'array',
        'is_active' => 'boolean',
        'last_triggered_at' => 'datetime',
        'last_failed_at' => 'datetime',
    ];

    // Relaciones
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Helpers
    public function incrementSuccess(): void
    {
        $this->increment('success_count');
        $this->last_triggered_at = now();
        $this->save();
    }

    public function incrementFailure(): void
    {
        $this->increment('failure_count');
        $this->last_failed_at = now();
        $this->save();
    }
}
