<?php

namespace Tests\Feature;

use App\Models\BreathingExercise;
use App\Models\BreathingCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BreathingExerciseControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @projet CESIZen
     * @module Exercices de respiration
     * @responsable Équipe CESIZen
     * @action Un invité accède à la liste des exercices
     * @attendu La page d’index des exercices est visible et retournée avec succès
     */
    public function test_guest_can_access_breathing_index()
    {
        $response = $this->get(route('breathing.index'));
        $response->assertStatus(200)
            ->assertViewIs('breathing.index');
    }

    /**
     * @projet CESIZen
     * @module Exercices de respiration
     * @responsable Équipe CESIZen
     * @action Un invité accède à un exercice actif
     * @attendu La page de détail de l’exercice est accessible avec les données de l’exercice
     */
    public function test_guest_can_access_breathing_show()
    {
        $category = BreathingCategory::factory()->create(['is_active' => true]);
        $exercise = BreathingExercise::factory()->create([
            'is_active' => true,
            'category_id' => $category->id
        ]);
        $response = $this->get(route('breathing.show', $exercise));
        $response->assertStatus(200)
            ->assertViewIs('breathing.show')
            ->assertViewHas('exercise', $exercise);
    }

    /**
     * @projet CESIZen
     * @module Exercices de respiration
     * @responsable Équipe CESIZen
     * @action Un invité tente d’accéder à un exercice inactif
     * @attendu Une erreur 404 est retournée
     */
    public function test_inactive_breathing_exercise_returns_404()
    {
        $category = BreathingCategory::factory()->create(['is_active' => true]);
        $exercise = BreathingExercise::factory()->create([
            'is_active' => false,
            'category_id' => $category->id
        ]);
        $response = $this->get(route('breathing.show', $exercise));
        $response->assertStatus(404);
    }
}
