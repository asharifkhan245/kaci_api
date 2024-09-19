<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info_Bank extends Model
{
    use HasFactory;
    protected $table ='info_bank';
    protected $fillable=[
        'toll',
        'country',
        'special_call_center',
    ];
}
