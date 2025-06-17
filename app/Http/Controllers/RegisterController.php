<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /**
     * @module Authentification
     * @description Affiche la page d'inscription
     * @return \Illuminate\View\View
     */
    public function view()
    {
        return view('auth.register');
    }

    /**
     * @module Authentification
     * @description Enregistre un nouvel utilisateur, déclenche l’email de vérification et connecte l'utilisateur
     * @param Request $request Les données de la requête d’inscription (nom, email, mot de passe)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice')->with('success', 'Inscription réussie ! Veuillez vérifier votre email.');
    }
}
