<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @module Authentification
     * @description Affiche la page de connexion
     * @return \Illuminate\View\View
     */
    public function view() {
        return view('auth.login');
    }

    /**
     * @module Authentification
     * @description Traite la tentative de connexion de l’utilisateur
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (auth()->attempt($request->only('email', 'password'))) {
            return redirect()->route('dashboard')->with('success', __('messages.auth.login_successful'));
        }

        return redirect()->back()->withErrors([__('messages.login.incorrect_credentials')])->withInput();
    }

    /**
     * @module Authentification
     * @description Déconnecte l’utilisateur courant et le redirige vers la page d’accueil
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout() {
        auth()->logout();
        return redirect()->route('index')->with('success', 'Vous êtes déconnectés.');
    }
}
