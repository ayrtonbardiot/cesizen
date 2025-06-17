<?php

namespace App\Http\Controllers;

use App\Models\BreathingExercise;
use App\Models\BreathingCategory;
use Illuminate\Http\Request;

class BreathingExerciseController extends Controller
{
    const CATEGORIES = [
        'stress' => 'Stress',
        'anxiety' => 'Anxiété',
        'focus' => 'Concentration',
        'sleep' => 'Sommeil',
        'energy' => 'Énergie',
        'meditation' => 'Méditation',
        'relaxation' => 'Relaxation'
    ];

    const DIFFICULTIES = [
        'beginner' => 'Débutant',
        'intermediate' => 'Intermédiaire',
        'advanced' => 'Avancé'
    ];

    /**
     * @module Respiration
     * @description Affiche la page d'exercice de respiration pour l'utilisateur connecté
     * @return \Illuminate\View\View
     */
    public function view(Request $request)
    {
        $user = auth()->user();
        return view('breathingexercise', ['user' => $user]);
    }

    /**
     * @module Respiration
     * @description Affiche la liste des exercices actifs avec filtrage par catégorie
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = BreathingExercise::query()->where('is_active', true);

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $exercises = $query->paginate(9);
        $categories = BreathingCategory::where('is_active', true)->get();

        return view('breathing.index', [
            'exercises' => $exercises,
            'categories' => $categories
        ]);
    }

    /**
     * @module Respiration
     * @description Affiche le détail d'un exercice actif ou erreur 404 si inactif
     * @return \Illuminate\View\View
     */
    public function show(BreathingExercise $exercise)
    {
        if (!$exercise->is_active) {
            abort(404);
        }

        $exercise->load('category');

        return view('breathing.show', compact('exercise'));
    }
}
