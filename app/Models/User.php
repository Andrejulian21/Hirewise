<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
     use HasFactory, Notifiable, SoftDeletes, HasRoles;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'password',
        'provider_name',
        'provider_id',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function setPasswordAttribute($value): void
    {
        if (is_null($value)) {
            $this->attributes['password'] = null;
            return;
        }

        $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }
    // --- Relaciones de dominio ---

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function candidate()
    {
        return $this->hasOne(Candidate::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

 
    public function appNotifications()
    {
        return $this->hasMany(\App\Models\AppNotification::class); 
    }

    public function sessionSocial()
    {
        return $this->hasOne(SessionSocial::class);
    }

    // Helpers útiles (opcionales)
    public function isEmpresa(): bool
    {
        return method_exists($this, 'hasRole') && $this->hasRole('Empresa');
    }

    public function isCandidato(): bool
    {
        return method_exists($this, 'hasRole') && $this->hasRole('Candidato');
    }
}
