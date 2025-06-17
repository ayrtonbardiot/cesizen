<?php

namespace App\Http\Controllers;

use App\Models\BreathingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * @module Profil
     * @description Affiche les informations du profil utilisateur connecté
     * @return \Illuminate\View\View
     */
    public function view() {
        $user = auth()->user();
        return view('profile', ['user' => $user]);
    }

    /**
     * @module Profil
     * @description Met à jour les informations de base de l’utilisateur (nom, email)
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request) {
        $user = auth()->user();

        if ($request->email === $user->email && $request->name === $user->name) {
            return back()->with('info', 'Aucune modification détectée.');
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)]
        ];

        $validated = $request->validate($rules);
        $user->update($validated);

        return back()->with('success', 'Update successfull.');
    }

    /**
     * @module Profil
     * @description Met à jour le mot de passe de l’utilisateur
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request) {
        $user = auth()->user();

        $validated = $request->validate([
            'current_password' => 'current_password',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user->update($validated);

        return back()->with('success', 'Password successfully updated');
    }

    /**
     * @module Profil
     * @description Génère un fichier JSON contenant les données personnelles de l’utilisateur
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse
     */
    public function downloadPersonalData()
    {
        try {
            $user = auth()->user();
            $breathingSessions = $user->breathingSessions()->get()->toArray();
            $userData = $user->toArray();

            $fileName = 'cesizen_personaldata.json';
            $tempPath = 'tmp/' . Str::uuid() . '_' . $fileName;

            $data = [
                'user' => $userData,
                'breathing_sessions' => $breathingSessions
            ];

            $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            Storage::disk('local')->put($tempPath, $json);

            $absolutePath = Storage::disk('local')->path($tempPath);
            return response()->download($absolutePath, $fileName)->deleteFileAfterSend(true);
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Une erreur est survenue lors du téléchargement de vos données.');
        }
    }

    /**
     * @module Profil
     * @description Supprime le compte de l’utilisateur (hors administrateur), les tokens et les sessions associées
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAccount(Request $request) {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Un administrateur ne peut pas supprimer son compte.');
        }

        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        DB::table('sessions')->where('user_id', $user->id)->delete();

        if (method_exists($user, 'tokens')) {
            $user->tokens()->delete();
        }

        $user->delete();

        return redirect('/')->with('info', 'Compte supprimé avec succès.');
    }
}
