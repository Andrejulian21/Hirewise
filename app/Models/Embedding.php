<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Embedding extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'embeddable_type',
        'embeddable_id',
        'model',
        'dimensions',
        'version',
        'vector',
        'hash',
        'is_active',
        'company_id',
        'generated_at',
        'metadata',
    ];

    protected $casts = [
        'vector' => 'array',
        'is_active' => 'boolean',
        'metadata' => 'array',
        'generated_at' => 'datetime',
    ];

    // Relaciones
    public function embeddable()
    {
        return $this->morphTo();
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
