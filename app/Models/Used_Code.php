<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Used_Code extends Model
{
    use HasFactory;
    protected $table='used_code';
    protected $fillable=[
        'user_id',
        'code',
        'expiry_date',
        'code_id',
        'status',
    ];
}
