<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BreathingSession;

class BreathingSessionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'exercise_id' => 'required|exists:breathing_exercises,id',
            'duration' => 'required|integer|min:1',
        ]);
    
        $session = BreathingSession::create([
            'user_id' => optional($request->user())->id, // null si invité
            'breathing_exercise_id' => $validated['exercise_id'],
            'duration_seconds' => $validated['duration'],
            'started_at' => now(),
            'ended_at' => now()->addSeconds($validated['duration']),
        ]);
    
        return response()->json(['message' => 'Session enregistrée.', 'id' => $session->id]);
    }
}
