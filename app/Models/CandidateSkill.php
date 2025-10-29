<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CandidateSkill extends Pivot
{
    protected $table = 'candidate_skill';
    public $timestamps = false;

    protected $fillable = ['candidate_id', 'skill_id', 'level'];
}
