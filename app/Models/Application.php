<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory, SoftDeletes;
    public $timestamps = true;

    protected $fillable = [
        'candidate_id', 'job_id', 'status', 'score'
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
