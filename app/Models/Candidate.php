<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'summary',
        'experience_years',
        'education',
        'cv_file',
        'linkedin_url',
        'photo_path',
    ];

    protected $casts = [
        'experience_years' => 'integer',
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
        return $this->belongsToMany(\App\Models\Skill::class, 'candidate_skill')
                    ->withPivot('level');
    }
    public function matchScores()
    {
        return $this->hasMany(MatchScore::class);
    }

    public function getPhotoUrlAttribute(): string
{
    if ($this->photo_path) {
        return \Illuminate\Support\Facades\Storage::url($this->photo_path);
    }
    return 'https://ui-avatars.com/api/?name='.urlencode(optional($this->user)->name).'&background=0D1B2A&color=fff';
}
}
