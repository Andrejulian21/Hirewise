<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicationStageChange extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'application_id',
        'from_stage_id',
        'to_stage_id',
        'changed_by',
        'changed_at',
        'notes',
        'metadata',
    ];

    protected $casts = [
        'changed_at' => 'datetime',
        'metadata' => 'array',
    ];

    // Relaciones
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function fromStage()
    {
        return $this->belongsTo(ApplicationStage::class, 'from_stage_id');
    }

    public function toStage()
    {
        return $this->belongsTo(ApplicationStage::class, 'to_stage_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
