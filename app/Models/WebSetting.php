<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebSetting extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'web_settings';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'company_id',
        'theme',
        'primary_color',
        'secondary_color',
        'logo_path',
        'favicon_path',
        'language',
        'timezone',
        'maintenance_mode',
        'navigation_links',
        'custom_scripts',
        'require_cookie_consent',
        'privacy_policy_url',
        'terms_url',
    ];

    protected $casts = [
        'maintenance_mode' => 'boolean',
        'require_cookie_consent' => 'boolean',
        'navigation_links' => 'array',
        'custom_scripts' => 'array',
    ];

    // Relaciones
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
