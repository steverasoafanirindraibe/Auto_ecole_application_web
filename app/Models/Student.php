<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'students';

    protected $fillable = [
        'last_name',
        'first_name',
        'email',
        'phone',
        'cin',        
        'birth_date',
        'gender',
        'profile_picture',
        'residence_certificate',
        'password',
        'previous_license',
        'payement_receipt',
        'training_id',
        'status'
    ];

    public static function validate(array $data, $isUpdate = false)
    {
        // Calcul de l'âge en PHP
       $age = isset($data['birth_date']) ? Carbon::parse($data['birth_date'])->age : null;


        $validator = Validator::make($data, [
            'last_name' => 'required|string|min:3|max:50',
            'first_name' => 'nullable|string|min:3|max:100',
            'email' => 'nullable|email|unique:students,email,' . ($isUpdate ? $data['id'] : ''),
            'phone' => 'nullable|regex:/^(261|032|033|034|037|038)\d{7}$/|size:10',
            'cin' => [
                'nullable',
                'regex:/^\d{5}[12]\d{6}$/',
                'required_if:age,>=18',
                'unique:students,cin,' . ($isUpdate ? $data['id'] : ''),
            ],
            'profile_picture' => 'required|string',
            'residence_certificate' => 'required|string',
            'payement_receipt' => 'required|string',
            'training_id' => 'nullable|exists:trainings,id',
            'status' => 'nullable|in:pending,validated,rejected',
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'nullable|in:1,2', 
        ], [
            'last_name.required' => 'Le nom de famille est obligatoire.',
            'last_name.string' => 'Le nom de famille doit être une chaîne de caractères.',
            'last_name.min' => 'Le nom de famille doit comporter au moins 3 caractères.',
            'last_name.max' => 'Le nom de famille ne doit pas dépasser 50 caractères.',            
            'first_name.string' => 'Le prénom doit être une chaîne de caractères.',
            'first_name.min' => 'Le prénom doit comporter au moins 3 caractères.',
            'first_name.max' => 'Le prénom ne doit pas dépasser 100 caractères.',
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email doit être une adresse valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'phone.regex' => 'Le numéro de téléphone doit commencer par 261, 032, 033, 034, 037 ou 038 et être suivi de 7 chiffres.',
            'phone.size' => 'Le numéro de téléphone doit contenir exactement 10 chiffres.',
            'cin.regex' => 'Le CIN doit contenir exactement 12 chiffres, et le 6e chiffre doit être 1 ou 2.',
            'cin.required_if' => 'Le CIN est requis pour les personnes majeures (18 ans ou plus).',
            'cin.unique' => 'Ce CIN est déjà enregistré.',
            'birth_date.date' => 'La date de naissance doit être une date valide.',
            'birth_date.before' => 'La date de naissance doit être avant aujourd\'hui.',
            'gender.in' => 'Le sexe doit être 1 pour homme et 2 pour femme.',
            'profile_picture.required' => 'La photo de profil est obligatoire.',
            'payement_receipt.required' => 'Le reçu de paiement est obligatoire.',
            'status.in' => 'Le statut doit être parmi :pending, :validated ou :rejected.',
        ]);

        return $validator;
    }

    // Relations
    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    // Mutators
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = str_replace(' ', '', $value);
    }
}
