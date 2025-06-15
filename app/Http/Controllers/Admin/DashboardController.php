<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BreathingExercise;
use App\Models\BreathingSession;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalExercises = BreathingExercise::count();
        $totalSessions = BreathingSession::count();

        $recentActivities = BreathingSession::take(10)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalExercises',
            'totalSessions',
            'recentActivities'
        ));
    }
} 