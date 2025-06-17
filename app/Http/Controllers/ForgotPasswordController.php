<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * @module Authentification
     * @description Affiche le formulaire de réinitialisation de mot de passe
     * @return \Illuminate\View\View
     */
    public function view()
    {
        return view('auth.forgot-password');
    }

    /**
     * @module Authentification
     * @description Envoie un lien de réinitialisation de mot de passe à l’adresse fournie
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
}
