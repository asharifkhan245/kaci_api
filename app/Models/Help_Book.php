<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Help_Book extends Model
{
    use HasFactory;
    protected $table='help_book';
    protected $fillable=[
'logo',
'title',
'description',
'country',
'contact_number',
'website_email',
'address',
'images',
'email',
    'status',
    ];
}
