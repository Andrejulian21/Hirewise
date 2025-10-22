<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'email_templates';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'company_id',
        'name',
        'slug',
        'subject',
        'category',
        'body_html',
        'body_text',
        'placeholders',
        'language',
        'is_active',
        'is_system',
        'last_used_at',
        'metadata',
    ];

    protected $casts = [
        'placeholders' => 'array',
        'is_active' => 'boolean',
        'is_system' => 'boolean',
        'last_used_at' => 'datetime',
        'metadata' => 'array',
    ];

    // Relaciones
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
