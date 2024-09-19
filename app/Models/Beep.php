<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beep extends Model
{
    use HasFactory;
    protected $table="beep";
    protected $fillable=[
   'title',
   'country',
   'location',
   'media',
   'like',
   'comment',
   'description',
   'user_id',
   'anonymous',
   'status',
   'reference_code',
   'featured'
    ];
}
