<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @projet CESIZen
     * @module Accueil
     * @responsable Équipe CESIZen
     * @action Accès à la page d'accueil en tant que visiteur
     * @attendu La page d'accueil s'affiche correctement avec la vue "index"
     */
    public function test_guest_can_see_index_page(): void
    {
        $response = $this->get(route('index'));
        $response->assertStatus(200)
                 ->assertViewIs('index');
    }

    /**
     * @projet CESIZen
     * @module Accueil
     * @responsable Équipe CESIZen
     * @action Accès à la page d'accueil en tant qu'utilisateur connecté
     * @attendu L'utilisateur est redirigé vers le tableau de bord
     */
    public function test_authenticated_user_is_redirected_to_dashboard(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('index'));
        $response->assertRedirect(route('dashboard'));
    }
} 