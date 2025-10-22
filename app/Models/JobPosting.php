<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobPosting extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'job_postings';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'company_id','created_by',
        'title','description','requirements','skills',
        'seniority','employment_type','modality',
        'country_code','state','city',
        'salary_min','salary_max','currency',
        'status','published_at','closed_at',
        'source','settings',
    ];

    protected $casts = [
        'requirements' => 'array',
        'skills'       => 'array',
        'settings'     => 'array',
        'salary_min'   => 'float',
        'salary_max'   => 'float',
        'published_at' => 'datetime',
        'closed_at'    => 'datetime',
    ];
}
