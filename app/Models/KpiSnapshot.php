<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KpiSnapshot extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kpi_snapshots';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'company_id',
        'report_definition_id',
        'kpi_key',
        'kpi_name',
        'category',
        'value',
        'unit',
        'period_start',
        'period_end',
        'previous_value',
        'variation',
        'is_improvement',
        'source_data',
        'metadata',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'value' => 'float',
        'previous_value' => 'float',
        'variation' => 'float',
        'is_improvement' => 'boolean',
        'source_data' => 'array',
        'metadata' => 'array',
    ];

    // Relaciones
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function reportDefinition()
    {
        return $this->belongsTo(ReportDefinition::class);
    }
}
