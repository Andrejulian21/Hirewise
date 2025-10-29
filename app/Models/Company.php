<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory;
    use HasFactory, SoftDeletes;
    public $timestamps = true;

    protected $fillable = [
        'user_id', 'name', 'description',
        'website', 'logo', 'plan_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
