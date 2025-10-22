<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MatchExplanation extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'match_id',
        'factors',
        'top_matches',
        'gaps',
        'rationale',
        'metadata',
        'model_used',
        'version',
    ];

    protected $casts = [
        'factors'     => 'array',
        'top_matches' => 'array',
        'gaps'        => 'array',
        'metadata'    => 'array',
    ];

    // Relaciones
    public function match()
    {
        return $this->belongsTo(Matches::class);
    }
}
