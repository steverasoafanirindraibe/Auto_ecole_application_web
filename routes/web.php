<?php

use Illuminate\Support\Facades\Route;


// Charger les routes API
Route::prefix('api')->middleware('api')->group(function () {
    require base_path('routes/api/student.php');
    
});

// Charger ici les routes Web


// Route d'accueil
Route::get('/', function () {
    return view('welcome');
});
