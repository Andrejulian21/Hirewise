<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicationStage extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'company_id',
        'name',
        'order',
        'color',
        'is_final',
        'is_default',
        'description',
        'settings',
    ];

    protected $casts = [
        'is_final' => 'boolean',
        'is_default' => 'boolean',
        'settings' => 'array',
    ];

    // Relaciones
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
