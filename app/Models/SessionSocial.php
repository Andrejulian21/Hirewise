<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SessionSocial extends Model
{
    use HasFactory;

    protected $table = 'sessions_social';

    protected $fillable = [
        'user_id', 'provider_name', 'access_token',
        'refresh_token', 'expires_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
