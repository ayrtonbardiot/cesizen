<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class AdminSettingsControllerTest extends TestCase
{
    use RefreshDatabase;

    private function admin() {
        /** @var User $admin */
        return User::factory()->create(['role' => 'admin']);
    }

    /**
     * @projet CESIZen
     * @module Paramètres de la plateforme
     * @responsable Équipe CESIZen
     * @action Affichage du formulaire de modification des paramètres par un admin
     * @attendu L'administrateur accède à la vue 'admin.settings' avec un statut HTTP 200
     */
    public function test_admin_can_see_settings_edit()
    {
        $admin = $this->admin();
        $response = $this->actingAs($admin)->get(route('admin.settings'));
        $response->assertStatus(200)
            ->assertViewIs('admin.settings');
    }

    /**
     * @projet CESIZen
     * @module Paramètres de la plateforme
     * @responsable Équipe CESIZen
     * @action Mise à jour des paramètres de la plateforme par un administrateur
     * @attendu Les nouvelles données sont stockées, la session contient un message de succès, et les paramètres sont mis en cache
     */
    public function test_admin_can_update_settings()
    {
        $admin = $this->admin();
        $data = [
            'site_name' => 'CESIZen',
            'site_description' => 'Plateforme bien-être',
            'contact_email' => 'contact@cesizen.com',
            'contact_phone' => '0123456789',
            'maintenance_mode' => false,
            'maintenance_message' => '',
            '_token' => csrf_token(),
        ];
        $response = $this->actingAs($admin)
            ->put(route('admin.settings.update'), $data);
        $response->assertRedirect(route('admin.settings'));
        $response->assertSessionHas('success');
        $this->assertTrue(Cache::has('site_settings'));
    }
}
