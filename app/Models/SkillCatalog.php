<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SkillCatalog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'skills_catalog';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'category',
        'type',
        'slug',
        'level_scale',
        'synonyms',
        'embedding_vector',
        'is_active',
    ];

    protected $casts = [
        'synonyms' => 'array',
        'embedding_vector' => 'array',
        'is_active' => 'boolean',
    ];
}
