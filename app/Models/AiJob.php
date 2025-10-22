<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AiJob extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'task_type',
        'company_id',
        'user_id',
        'related_id',
        'related_type',
        'provider_id',
        'status',
        'started_at',
        'completed_at',
        'attempts',
        'error_message',
        'input',
        'output',
        'metadata',
    ];

    protected $casts = [
        'input' => 'array',
        'output' => 'array',
        'metadata' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
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

    public function provider()
    {
        return $this->belongsTo(AiProvider::class, 'provider_id');
    }

    public function related()
    {
        return $this->morphTo(__FUNCTION__, 'related_type', 'related_id');
    }
}
