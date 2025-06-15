<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @projet CESIZen
     * @module Tableau de bord (Admin)
     * @responsable Équipe CESIZen
     * @action Empêcher un utilisateur non admin d'accéder au tableau de bord admin
     * @attendu Un utilisateur ayant le rôle 'utilisateur' est redirigé (HTTP 302)
     */
    public function test_non_admin_cannot_access_admin_dashboard()
    {
        $user = User::factory()->create(['role' => 'utilisateur']);
        $response = $this->actingAs($user)->get(route('admin.dashboard'));
        $response->assertStatus(302);
    }

    /**
     * @projet CESIZen
     * @module Tableau de bord (Admin)
     * @responsable Équipe CESIZen
     * @action Permettre à un administrateur d'accéder au tableau de bord admin
     * @attendu L'administrateur accède à la vue 'admin.dashboard' avec un statut HTTP 200
     */
    public function test_admin_can_access_admin_dashboard()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        $response->assertStatus(200)
            ->assertViewIs('admin.dashboard');
    }
}
