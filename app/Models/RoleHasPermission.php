<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoleHasPermission extends Model
{
    use HasFactory;

    protected $table = 'role_has_permissions';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'role_id',
        'permission_id',
        'company_id',
        'is_granted',
        'metadata',
    ];

    protected $casts = [
        'is_granted' => 'boolean',
        'metadata' => 'array',
    ];

    // Relaciones
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
