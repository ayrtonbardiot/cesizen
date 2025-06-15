<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function view() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (auth()->attempt($request->only('email', 'password'))) {
            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }

        return redirect()->back()->withErrors([__('messages.login.incorrect_credentials')])->withInput();
    }

    public function logout() {
        auth()->logout();
        return redirect()->route('index')->with('success', 'Logout successful!');
    }
}
