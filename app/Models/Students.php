<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;

    //Prevents SQL Injection by instructing Laravel to only accept data containing the specified keys / variables.
    protected $fillable = [
        'name', 'email', 'address', 'course'
    ];
}
