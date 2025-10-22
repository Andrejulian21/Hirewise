<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AiProvider extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'provider_key',
        'type',
        'api_base_url',
        'default_model',
        'available_models',
        'is_active',
        'auth_method',
        'api_key',
        'metadata',
    ];

    protected $casts = [
        'available_models' => 'array',
        'is_active' => 'boolean',
        'metadata' => 'array',
    ];

    // Relaciones
    public function aiJobs()
    {
        return $this->hasMany(AiJob::class, 'provider_id');
    }
}
