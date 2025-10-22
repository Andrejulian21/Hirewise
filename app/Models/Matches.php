<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matches extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'job_posting_id',
        'candidate_id',
        'company_id',
        'score',
        'breakdown',
        'model_used',
        'matched_at',
        'is_valid',
        'status',
        'processed_by',
        'metadata',
    ];

    protected $casts = [
        'score' => 'float',
        'is_valid' => 'boolean',
        'breakdown' => 'array',
        'metadata' => 'array',
        'matched_at' => 'datetime',
    ];

    // Relaciones
    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
