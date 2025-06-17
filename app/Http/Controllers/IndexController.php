<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BreathingExercise;
use App\Models\Article;

class IndexController extends Controller
{
    /**
     * @module Accueil
     * @description Affiche la page d’accueil avec les derniers exercices et articles, ou redirige vers le dashboard si connecté
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function view()
    {
        $user = auth()->user();
        if ($user) {
            return redirect()->route('dashboard');
        }

        $breathingExercises = BreathingExercise::where('is_active', true)
            ->with('category')
            ->latest()
            ->take(3)
            ->get();

        $articles = Article::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('index', compact('breathingExercises', 'articles'));
    }
}
