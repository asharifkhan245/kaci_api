<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsoredBeep extends Model
{

    protected $table = 'sponsored_beeps';

    protected $fillable = [
        'profile_name',
        'profile_image',
        'title',
        'description',
        'media',
        'link_name',
        'link',
        'country',
        'location',
        'status',
        'expire_date',
        'device_type'
    ];
    use HasFactory;
}
