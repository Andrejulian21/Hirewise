<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class CandidateSkill extends Pivot
{
    use HasFactory, SoftDeletes;
    protected $table = 'candidate_skill';
    public $timestamps = false;

    protected $fillable = ['candidate_id', 'skill_id', 'level'];
}
