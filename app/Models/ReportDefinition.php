<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportDefinition extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'report_definitions';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'company_id',
        'name',
        'slug',
        'category',
        'description',
        'data_source',
        'filters_schema',
        'columns',
        'aggregations',
        'is_active',
        'allowed_roles',
        'is_system',
    ];

    protected $casts = [
        'filters_schema' => 'array',
        'columns' => 'array',
        'aggregations' => 'array',
        'allowed_roles' => 'array',
        'is_active' => 'boolean',
        'is_system' => 'boolean',
    ];

    // Relaciones
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function reportRuns()
    {
        return $this->hasMany(ReportRun::class);
    }
}
