<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Interview extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'application_id',
        'candidate_id',
        'recruiter_id',
        'company_id',
        'title',
        'description',
        'mode',
        'location',
        'scheduled_at',
        'duration_minutes',
        'status',
        'feedback',
        'rating',
        'next_stage_id',
        'participants',
        'metadata',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'participants' => 'array',
        'metadata' => 'array',
    ];

    // Relaciones
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function recruiter()
    {
        return $this->belongsTo(User::class, 'recruiter_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function nextStage()
    {
        return $this->belongsTo(ApplicationStage::class, 'next_stage_id');
    }
}
