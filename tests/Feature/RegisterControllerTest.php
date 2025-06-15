<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @projet CESIZen
     * @module Inscription
     * @responsable Équipe CESIZen
     * @action Accès à la page d'inscription
     * @attendu La page de formulaire d'inscription est correctement affichée
     */
    public function test_guest_can_see_register_page()
    {
        $response = $this->get(route('register'));
        $response->assertStatus(200)
                 ->assertViewIs('auth.register');
    }

    /**
     * @projet CESIZen
     * @module Inscription
     * @responsable Équipe CESIZen
     * @action Inscription avec des données valides
     * @attendu L'utilisateur est enregistré, redirigé vers la vérification, et reçoit un email
     */
    public function test_user_can_register_with_valid_data()
    {
        Notification::fake();

        $response = $this->from(route('register'))
                         ->post(route('register.post'), [
                             'name' => 'Test User',
                             'email' => 'test@example.com',
                             'password' => 'password123',
                             'password_confirmation' => 'password123',
                             '_token' => csrf_token(),
                         ]);

        $response->assertRedirect(route('verification.notice'));

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'email_verified_at' => null,
        ]);

        Notification::assertSentTo(
            User::where('email', 'test@example.com')->first(),
            \App\Notifications\CustomVerifyEmail::class
        );
    }

    /**
     * @projet CESIZen
     * @module Inscription
     * @responsable Équipe CESIZen
     * @action Inscription avec un email déjà utilisé
     * @attendu L’inscription échoue et une erreur est renvoyée sur le champ email
     */
    public function test_user_cannot_register_with_existing_email()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $response = $this->from(route('register'))
                         ->post(route('register.post'), [
                             'name' => 'Test User',
                             'email' => 'test@example.com',
                             'password' => 'password123',
                             'password_confirmation' => 'password123',
                             '_token' => csrf_token(),
                         ]);

        $response->assertRedirect(route('register'))
                 ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    /**
     * @projet CESIZen
     * @module Inscription
     * @responsable Équipe CESIZen
     * @action Accès aux routes protégées sans vérification de l’email
     * @attendu L’utilisateur est redirigé vers la page de vérification d’email
     */
    public function test_unverified_user_cannot_access_protected_routes()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertRedirect(route('verification.notice'));
    }

    /**
     * @projet CESIZen
     * @module Inscription
     * @responsable Équipe CESIZen
     * @action Accès aux routes protégées après vérification de l’email
     * @attendu L’utilisateur accède au tableau de bord avec succès
     */
    public function test_verified_user_can_access_protected_routes()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
    }
}