<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @projet CESIZen
     * @module Connexion
     * @responsable Équipe CESIZen
     * @action Accès à la page de connexion
     * @attendu La vue de connexion s’affiche correctement (code 200)
     */
    public function test_guest_can_see_login_page()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200)
            ->assertViewIs('auth.login');
    }

    /**
     * @projet CESIZen
     * @module Connexion
     * @responsable Équipe CESIZen
     * @action Connexion avec identifiants valides
     * @attendu L’utilisateur est redirigé vers le tableau de bord
     */
    public function test_verified_user_can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $response = $this->from(route('login.post'))
            ->post(route('login.post'), [
                'email' => $user->email,
                'password' => 'password123',
                '_token' => csrf_token(),
            ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @projet CESIZen
     * @module Connexion
     * @responsable Équipe CESIZen
     * @action Connexion avec identifiants invalides
     * @attendu L’utilisateur reste invité et voit une erreur
     */
    public function test_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $response = $this->from(route('login'))
            ->post(route('login.post'), [
                'email' => $user->email,
                'password' => 'wrongpassword',
                '_token' => csrf_token(),
            ]);

        $response->assertRedirect(route('login'))
            ->assertSessionHasErrors();

        $this->assertGuest();
    }

    /**
     * @projet CESIZen
     * @module Connexion
     * @responsable Équipe CESIZen
     * @action Déconnexion d’un utilisateur
     * @attendu L’utilisateur est redirigé vers l’accueil et déconnecté
     */
    public function test_user_can_logout()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user);
        $response = $this->get(route('logout'));

        $response->assertRedirect(route('index'));
        $this->assertGuest();
    }
}
