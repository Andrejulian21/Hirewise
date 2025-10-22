<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'company_id',
        'job_posting_id',
        'candidate_id',
        'recruiter_id',
        'status',
        'applied_at',
        'last_status_change_at',
        'source',
        'match_score',
        'match_breakdown',
        'notes',
        'metadata',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
        'last_status_change_at' => 'datetime',
        'match_score' => 'float',
        'match_breakdown' => 'array',
        'metadata' => 'array',
    ];

    // Relaciones
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function recruiter()
    {
        return $this->belongsTo(User::class, 'recruiter_id');
    }
}
