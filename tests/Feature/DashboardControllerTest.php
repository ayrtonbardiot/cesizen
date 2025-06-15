<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @projet CESIZen
     * @module Tableau de bord
     * @responsable Équipe CESIZen
     * @action Un invité tente d’accéder au tableau de bord
     * @attendu Il est redirigé vers la page de connexion
     */
    public function test_guest_cannot_access_dashboard()
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));
    }

    /**
     * @projet CESIZen
     * @module Tableau de bord
     * @responsable Équipe CESIZen
     * @action Un utilisateur authentifié accède au tableau de bord
     * @attendu La vue dashboard est retournée avec les données de l’utilisateur
     */
    public function test_authenticated_user_can_see_dashboard()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('dashboard'));
        $response->assertStatus(200)
            ->assertViewIs('dashboard')
            ->assertViewHas('user', $user);
    }
}
