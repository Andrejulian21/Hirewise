<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name','slug','legal_name','tax_id',
        'email','phone','website',
        'logo_path','brand_color',
        'country_code','timezone','locale',
        'billing_email','billing_name','billing_address_line1','billing_address_line2',
        'billing_city','billing_state','billing_postal_code','billing_country_code',
        'status','trial_ends_at','onboarded_at',
        'settings','limits',
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'onboarded_at'  => 'datetime',
        'settings'      => 'array',
        'limits'        => 'array',
    ];
}
