<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    use HasFactory;

   
    protected $table = 'administrators';

   
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    
    protected $hidden = [
        'password',
    ];

    
    public static $rules = [
        'name' => 'required|string|max:100',
        'email' => 'required|email|unique:administrators,email',
        'password' => 'required|string|min:8|confirmed',
    ];

    // Définir un accessor pour hacher le mot de passe avant de le sauvegarder
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
