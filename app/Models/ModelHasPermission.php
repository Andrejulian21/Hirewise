<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelHasPermission extends Model
{
    use HasFactory;

    protected $table = 'model_has_permissions';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'permission_id',
        'model_type',
        'model_id',
        'company_id',
        'is_granted',
        'metadata',
    ];

    protected $casts = [
        'is_granted' => 'boolean',
        'metadata' => 'array',
    ];

    // Relaciones
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function model()
    {
        return $this->morphTo();
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
