<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;

    //1. Create REST APIs of Student Model
    //Prevents SQL Injection by instructing Laravel to only accept data containing the specified keys / variables.
    protected $fillable = [
        'name', 'email', 'address', 'course'
    ];
}
