<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportRun extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'report_runs';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'report_definition_id',
        'company_id',
        'executed_by',
        'status',
        'started_at',
        'completed_at',
        'filters_applied',
        'columns_selected',
        'output_format',
        'file_path',
        'row_count',
        'execution_time_seconds',
        'error_message',
        'metadata',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'filters_applied' => 'array',
        'columns_selected' => 'array',
        'metadata' => 'array',
    ];

    // Relaciones
    public function definition()
    {
        return $this->belongsTo(ReportDefinition::class, 'report_definition_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'executed_by');
    }
}
