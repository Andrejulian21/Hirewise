<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'max_jobs', 'price', 'description'];

    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
