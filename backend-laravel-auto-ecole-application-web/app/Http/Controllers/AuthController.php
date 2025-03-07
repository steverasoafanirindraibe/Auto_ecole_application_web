<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Création d'utilisateur
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        // Hashage du mot de passe AVANT sauvegarde
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);

        // Création du token avec des abilities (droits)
        $token = $user->createToken('auth_token', ['auto-ecole:manage'])->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    // Connexion
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Identifiants invalides'], 401);
        }

        // Récupère l'utilisateur ET vérifie s'il est actif
        $user = User::where('email', $request->email)->where('is_active', true)->firstOrFail();
        
        // Recrée un token à chaque connexion pour plus de sécurité
        $user->tokens()->delete();
        $token = $user->createToken('auth_token', ['auto-ecole:manage'])->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    // Déconnexion
    public function logout(Request $request)
    {
        // Supprime TOUS les tokens de l'utilisateur
        $request->user()->tokens()->delete();
        
        return response()->json(['message' => 'Déconnexion réussie']);
    }

    // Récupérer l'utilisateur connecté
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
