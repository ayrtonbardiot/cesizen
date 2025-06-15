<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\BreathingExercise;
use App\Models\BreathingCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminBreathingExerciseControllerTest extends TestCase
{
    use RefreshDatabase;

    private function admin()
    {
        /** @var User $admin */
        return User::factory()->create(['role' => 'admin']);
    }

    /**
     * @projet CESIZen
     * @module Exercices de respiration (Admin)
     * @responsable Équipe CESIZen
     * @action Accéder à l'index des exercices
     * @attendu L'admin accède à la vue 'admin.breathing.index'
     */
    public function test_admin_can_see_exercises_index()
    {
        $admin = $this->admin();
        $response = $this->actingAs($admin)->get(route('admin.breathing.index'));
        $response->assertStatus(200)->assertViewIs('admin.breathing.index');
    }

    /**
     * @projet CESIZen
     * @module Exercices de respiration (Admin)
     * @responsable Équipe CESIZen
     * @action Accéder au formulaire de création
     * @attendu La vue 'admin.breathing.create' est affichée
     */
    public function test_admin_can_see_create_form()
    {
        $admin = $this->admin();
        $response = $this->actingAs($admin)->get(route('admin.breathing.create'));
        $response->assertStatus(200)->assertViewIs('admin.breathing.create');
    }

    /**
     * @projet CESIZen
     * @module Exercices de respiration (Admin)
     * @responsable Équipe CESIZen
     * @action Créer un exercice
     * @attendu L'exercice est sauvegardé et l'utilisateur est redirigé
     */
    public function test_admin_can_store_exercise()
    {
        Storage::fake('public');
        $admin = $this->admin();
        $category = BreathingCategory::factory()->create(['is_active' => true]);
        $exercise = BreathingExercise::factory()->make(['category_id' => $category->id]);

        $data = [
            'title' => $exercise->title,
            'description' => $exercise->description,
            'category_id' => $exercise->category_id,
            'steps' => $exercise->steps,
            'is_active' => $exercise->is_active,
        ];

        $response = $this->actingAs($admin)->post(route('admin.breathing.store'), $data);
        $response->assertRedirect(route('admin.breathing.index'));

        $this->assertDatabaseHas('breathing_exercises', [
            'title' => $exercise->title,
        ]);
    }

    /**
     * @projet CESIZen
     * @module Exercices de respiration (Admin)
     * @responsable Équipe CESIZen
     * @action Modifier un exercice
     * @attendu Le formulaire d'édition est affiché avec l'exercice concerné
     */
    public function test_admin_can_edit_exercise()
    {
        $admin = $this->admin();
        $category = BreathingCategory::factory()->create(['is_active' => true]);
        $exercise = BreathingExercise::factory()->create(['category_id' => $category->id]);

        $response = $this->actingAs($admin)->get(route('admin.breathing.edit', $exercise));
        $response->assertStatus(200)
            ->assertViewIs('admin.breathing.edit')
            ->assertViewHas('breathing', $exercise);
    }

    /**
     * @projet CESIZen
     * @module Exercices de respiration (Admin)
     * @responsable Équipe CESIZen
     * @action Mettre à jour un exercice
     * @attendu Les données modifiées sont persistées en base
     */
    public function test_admin_can_update_exercise()
    {
        Storage::fake('public');
        $admin = $this->admin();
        $category = BreathingCategory::factory()->create(['is_active' => true]);
        $exercise = BreathingExercise::factory()->create(['category_id' => $category->id]);

        $data = [
            'title' => "$exercise->title updated",
            'description' => $exercise->description,
            'category_id' => $exercise->category_id,
            'steps' => $exercise->steps,
            'is_active' => $exercise->is_active,
        ];

        $response = $this->actingAs($admin)
            ->put(route('admin.breathing.update', ['breathing' => $exercise]), $data);

        $response->assertRedirect(route('admin.breathing.index'));

        $this->assertDatabaseHas('breathing_exercises', [
            'id' => $exercise->id,
            'title' => "$exercise->title updated",
        ]);
    }

    /**
     * @projet CESIZen
     * @module Exercices de respiration (Admin)
     * @responsable Équipe CESIZen
     * @action Supprimer un exercice
     * @attendu L'exercice est retiré de la base de données
     */
    public function test_admin_can_delete_exercise()
    {
        $admin = $this->admin();
        $category = BreathingCategory::factory()->create(['is_active' => true]);
        $exercise = BreathingExercise::factory()->create(['category_id' => $category->id]);

        $response = $this->actingAs($admin)
            ->delete(route('admin.breathing.destroy', $exercise));

        $response->assertRedirect(route('admin.breathing.index'));

        $this->assertDatabaseMissing('breathing_exercises', [
            'id' => $exercise->id
        ]);
    }

    /**
     * @projet CESIZen
     * @module Exercices de respiration (Admin)
     * @responsable Équipe CESIZen
     * @action Voir un exercice
     * @attendu La vue détail est affichée avec l'exercice
     */
    public function test_admin_can_show_exercise()
    {
        $admin = $this->admin();
        $category = BreathingCategory::factory()->create(['is_active' => true]);
        $exercise = BreathingExercise::factory()->create(['category_id' => $category->id]);

        $response = $this->actingAs($admin)->get(route('admin.breathing.show', $exercise));
        $response->assertStatus(200)
            ->assertViewIs('admin.breathing.show', ['breathing' => $exercise])
            ->assertViewHas('breathing', $exercise);
    }
}
