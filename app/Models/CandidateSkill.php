<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CandidateSkill extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'candidate_id',
        'skill_id',
        'company_id',
        'name',
        'proficiency',
        'years_experience',
        'verified',
        'source',
        'metadata',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'metadata' => 'array',
    ];

    // Relaciones
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function skill()
    {
        return $this->belongsTo(SkillCatalog::class, 'skill_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
