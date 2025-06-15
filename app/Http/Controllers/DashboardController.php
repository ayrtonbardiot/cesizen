<?php

namespace App\Http\Controllers;

use App\Models\BreathingSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function view() {
        $user = Auth::user();

        $breathingTotal = $user->breathingSessions()->count();
        $currentStreak = $user->currentBreathingStreak();

        return view('dashboard', ['user' => $user, 'breathingTotal' => $breathingTotal, 'currentStreak' => $currentStreak]);
    }
}
