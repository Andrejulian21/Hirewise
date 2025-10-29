<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'title', 'description',
        'requirements', 'location',
        'salary_min', 'salary_max', 'status'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skill')
                    ->withPivot('importance');
    }

    public function matchScores()
    {
        return $this->hasMany(MatchScore::class);
    }
}
