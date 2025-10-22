<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApiToken extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'api_tokens';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'api_client_id',
        'user_id',
        'company_id',
        'name',
        'token',
        'scopes',
        'last_used_at',
        'expires_at',
        'revoked',
        'ip_address',
        'user_agent',
        'metadata',
    ];

    protected $casts = [
        'scopes' => 'array',
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
        'revoked' => 'boolean',
        'metadata' => 'array',
    ];

    // Relaciones
    public function apiClient()
    {
        return $this->belongsTo(ApiClient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Helpers
    public function revoke(): void
    {
        $this->revoked = true;
        $this->save();
    }

    public function isExpired(): bool
    {
        return $this->expires_at && now()->greaterThan($this->expires_at);
    }
}
