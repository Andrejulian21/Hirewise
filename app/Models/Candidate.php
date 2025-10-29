<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'summary', 'experience_years',
        'education', 'cv_file', 'linkedin_url'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'candidate_skill')
                    ->withPivot('level');
    }

    public function matchScores()
    {
        return $this->hasMany(MatchScore::class);
    }
}
