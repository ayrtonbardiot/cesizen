<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Notifications\CustomResetPasswordEmail;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @projet CESIZen
     * @module Authentification
     * @responsable Équipe CESIZen
     * @action Voir la page mot de passe oublié
     * @attendu La vue 'auth.forgot-password' est affichée
     */
    public function test_forgot_password_page_is_accessible()
    {
        $response = $this->get(route('password.request'));
        $response->assertStatus(200);
    }

    /**
     * @projet CESIZen
     * @module Authentification
     * @responsable Équipe CESIZen
     * @action Envoyer le mail de réinitialisation avec un email valide
     * @attendu L'utilisateur reçoit un mail avec un lien de réinitialisation
     */
    public function test_can_send_password_reset_email_to_valid_user()
    {
        Notification::fake();
        $user = User::factory()->create();

        $response = $this->post(route('password.email'), [
            'email' => $user->email,
        ]);

        $response->assertSessionHas('status');
        Notification::assertSentTo($user, CustomResetPasswordEmail::class);
    }

    /**
     * @projet CESIZen
     * @module Authentification
     * @responsable Équipe CESIZen
     * @action Envoyer le mail de réinitialisation avec un email inconnu
     * @attendu Aucun mail n'est envoyé et une erreur est affichée
     */
    public function test_no_email_sent_to_unknown_user()
    {
        Notification::fake();

        $response = $this->from(route('password.request'))->post(route('password.email'), [
            'email' => 'unknown@example.com',
        ]);

        $response->assertRedirect(route('password.request'));
        $response->assertSessionHasErrors('email');
        Notification::assertNothingSent();
    }

    /**
     * @projet CESIZen
     * @module Authentification
     * @responsable Équipe CESIZen
     * @action Réinitialiser le mot de passe avec un token valide
     * @attendu Le mot de passe est mis à jour et l'utilisateur est redirigé
     */
    public function test_can_reset_password_with_valid_token()
    {
        Notification::fake();
        $user = User::factory()->create();

        $this->post(route('password.email'), ['email' => $user->email]);

        Notification::assertSentTo($user, CustomResetPasswordEmail::class, function ($notification) use ($user, &$token) {
            $token = $notification->token;
            return true;
        });

        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertCredentials(['email' => $user->email, 'password' => 'newpassword123']);
    }

    /**
     * @projet CESIZen
     * @module Authentification
     * @responsable Équipe CESIZen
     * @action Réinitialiser le mot de passe avec un token invalide
     * @attendu Une erreur est retournée et le mot de passe n'est pas changé
     */
    public function test_cannot_reset_password_with_invalid_token()
    {
        $user = User::factory()->create();

        $response = $this->from(route('password.reset', ['token' => 'fake-token']))
            ->post(route('password.update'), [
                'token' => 'fake-token',
                'email' => $user->email,
                'password' => 'newpassword123',
                'password_confirmation' => 'newpassword123',
            ]);

        $response->assertRedirect(route('password.reset', ['token' => 'fake-token']));
        $response->assertSessionHasErrors();
        $this->assertFalse(Hash::check('newpassword123', $user->fresh()->password));
    }

        /**
     * @projet CESIZen
     * @module Authentification
     * @responsable Équipe CESIZen
     * @action Tenter de réinitialiser avec le même mot de passe
     * @attendu Le mot de passe est rejeté avec un message d'erreur
     */
    public function test_cannot_reset_password_with_same_as_old()
    {
        Notification::fake();

        $user = User::factory()->create([
            'password' => bcrypt('ancienmdp123'),
        ]);

        // Générer token
        $this->post(route('password.email'), ['email' => $user->email]);

        Notification::assertSentTo($user, CustomResetPasswordEmail::class, function ($notification) use (&$token) {
            $token = $notification->token;
            return true;
        });

        // Tentative de réinitialisation avec le même mot de passe
        $response = $this->from(route('password.reset', $token))->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'ancienmdp123',
            'password_confirmation' => 'ancienmdp123',
        ]);

        $response->assertRedirect(route('password.reset', $token));
        $response->assertSessionHasErrors('password');
        $this->assertTrue(Hash::check('ancienmdp123', $user->fresh()->password)); // toujours l’ancien
    }
}
