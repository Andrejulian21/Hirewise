<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParsedDocument extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'resume_id',
        'company_id',
        'candidate_id',
        'source_type',
        'language',
        'is_valid',
        'raw_text',
        'entities',
        'structure',
        'status',
        'processed_at',
        'error_message',
        'metadata',
    ];

    protected $casts = [
        'is_valid' => 'boolean',
        'entities' => 'array',
        'structure' => 'array',
        'metadata' => 'array',
        'processed_at' => 'datetime',
    ];

    // Relaciones
    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
