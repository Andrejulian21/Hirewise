<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OutboxEvent extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'outbox_events';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'company_id',
        'aggregate_type',
        'aggregate_id',
        'event_name',
        'event_version',
        'correlation_id',
        'causation_id',
        'destination',
        'headers',
        'payload',
        'status',
        'attempts',
        'next_attempt_at',
        'dispatched_at',
        'failed_at',
        'error_message',
        'partition_key',
        'ordering_key',
    ];

    protected $casts = [
        'headers'         => 'array',
        'payload'         => 'array',
        'attempts'        => 'integer',
        'next_attempt_at' => 'datetime',
        'dispatched_at'   => 'datetime',
        'failed_at'       => 'datetime',
    ];

    // Relaciones
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
