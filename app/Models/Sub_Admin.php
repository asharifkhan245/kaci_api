<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_Admin extends Model
{
    use HasFactory;
    protected $table='sub_admin';
    protected $fillable=[
        'name',
        'email',
        'phone_number',
        'password',
        'role',
        'privilage',
        'profile_image',
        'about',
    ];
}
