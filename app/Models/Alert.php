<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;
    protected $table='alert';
    protected $fillable=[
        'description',
        'images',
        'push_notification',
        'resident_country',
        'title',
    'status'
    ];
}
