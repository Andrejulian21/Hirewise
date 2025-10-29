<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MatchScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id', 'candidate_id', 'compatibility_score', 'analyzed_at'
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
