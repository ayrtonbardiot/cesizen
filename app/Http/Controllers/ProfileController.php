<?php

namespace App\Http\Controllers;

use App\Models\BreathingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function view() {
        $user = auth()->user();
        return view('profile', ['user' => $user]);
    }

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

        //todo: insérer messages traduction
        return back()->with('success', 'Update successfull.');
    }

    public function updatePassword(Request $request) {
        $user = auth()->user();

        $validated = $request->validate([
            'current_password' => 'current_password',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user->update($validated);

        return back()->with('success', 'Password successfully updated');
    }


    public function downloadPersonalData()
    {
        try {
            $user = auth()->user();
            $breathingSessions = $user->breathingSessions()->get()->toArray();
            $userData = $user->toArray();
    
            $fileName = 'cesizen_personaldata.json';

            // on utilise un UUID pour la sécurité
            $tempPath = 'tmp/' . Str::uuid() . '_' . $fileName;
    
            $data = [
                // 'user' => [
                //     'id'         => $user->id,
                //     'name'       => $user->name,
                //     'email'      => $user->email,
                //     'last_login_at' => $user->last_login_at,
                //     'last_login_ip_address' => $user->last_login_ip_address,
                //     'created_at' => $user->created_at,
                //     'updated_at' => $user->updated_at,
                // ],
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

    public function deleteAccount(Request $request) {
        $user = auth()->user();

        $user->breathingSessions()->delete();
        $user->delete();

        auth()->logout();
    
        // Invalider la session
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect('/')->with('status', 'Compte supprimé avec succès.');
    }
}
