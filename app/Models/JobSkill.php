<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobSkill extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'job_posting_id',
        'skill_id',
        'company_id',
        'name',
        'importance',
        'proficiency',
        'priority',
        'verified',
        'metadata',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'metadata' => 'array',
    ];

    // Relaciones
    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
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
