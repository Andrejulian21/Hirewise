<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category'];

    public function candidates()
    {
        return $this->belongsToMany(Candidate::class, 'candidate_skill')
                    ->withPivot('level');
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_skill')
                    ->withPivot('importance');
    }
}
