<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles; 

    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'password',
        'provider_name',
        'provider_id'
    ];

    protected $hidden = ['password'];

 
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

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function sessionSocial()
    {
        return $this->hasOne(SessionSocial::class);
    }
}
