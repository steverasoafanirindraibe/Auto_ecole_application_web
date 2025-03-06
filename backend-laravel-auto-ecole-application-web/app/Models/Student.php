<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'students_firstname',
        'students_lastname',
        'students_contact',
        'students_email',
        'students_password'
    ];
}
