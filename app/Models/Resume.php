<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resume extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'candidate_id',
        'company_id',
        'uploaded_by',
        'original_filename',
        'stored_path',
        'mime_type',
        'size_bytes',
        'hash',
        'extracted_text',
        'parsed_data',
        'is_parsed',
        'status',
        'processed_at',
        'metadata',
    ];

    protected $casts = [
        'is_parsed' => 'boolean',
        'processed_at' => 'datetime',
        'parsed_data' => 'array',
        'metadata' => 'array',
    ];

    // Relaciones
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
