<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Non_Profit extends Model
{
    use HasFactory;
    protected $table="non_profit";
    protected $fillable=[
        'non_profit',
    ];
}
