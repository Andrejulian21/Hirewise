<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidate extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'company_id',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'headline',
        'summary',
        'skills',
        'languages',
        'seniority',
        'education_level',
        'years_experience',
        'current_position',
        'current_company',
        'country_code',
        'state',
        'city',
        'resume_path',
        'linkedin_url',
        'portfolio_url',
        'status',
        'metadata',
    ];

    protected $casts = [
        'skills' => 'array',
        'languages' => 'array',
        'metadata' => 'array',
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
}
