<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @projet CESIZen
     * @module Vérification Email
     * @responsable Équipe CESIZen
     * @action Lors de l’inscription, un email de vérification est envoyé
     * @attendu L’utilisateur reçoit une notification CustomVerifyEmail
     */
    public function test_verification_email_is_sent_on_registration(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'email_verified_at' => null,
        ]);

        event(new Registered($user));

        Notification::assertSentTo(
            $user,
            \App\Notifications\CustomVerifyEmail::class
        );
    }

    /**
     * @projet CESIZen
     * @module Vérification Email
     * @responsable Équipe CESIZen
     * @action Contenu du mail de vérification
     * @attendu L’email contient le texte traduit et l’URL signée
     */
    public function test_verification_email_contains_correct_content(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ]);

        $user->sendEmailVerificationNotification();

        Notification::assertSentTo(
            $user,
            \App\Notifications\CustomVerifyEmail::class,
            function ($notification, $channels) use ($user) {
                $mail = $notification->toMail($user);
                $rendered = view('emails.verify-email', $mail->viewData)->render();

                $this->assertStringContainsString(__('auth.verify_email_greeting', ['name' => $user->name]), $rendered);
                $this->assertStringContainsString(__('auth.verify_email_text'), $rendered);
                $this->assertStringContainsString(__('auth.verify_email_button'), $rendered);
                $this->assertStringContainsString('/email/verify', $mail->viewData['verificationUrl']);
                $this->assertStringContainsString('signature=', $mail->viewData['verificationUrl']);
                return true;
            }
        );
    }

    /**
     * @projet CESIZen
     * @module Vérification Email
     * @responsable Équipe CESIZen
     * @action Utilisation d’un lien valide de vérification
     * @attendu L’email de l’utilisateur est marqué comme vérifié
     */
    public function test_verification_link_works(): void
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertRedirect(route('dashboard'));
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    /**
     * @projet CESIZen
     * @module Vérification Email
     * @responsable Équipe CESIZen
     * @action Utilisation d’un lien expiré
     * @attendu La vérification échoue avec un code 403
     */
    public function test_verification_link_expires(): void
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->subMinutes(1),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertStatus(403);
        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }

    /**
     * @projet CESIZen
     * @module Vérification Email
     * @responsable Équipe CESIZen
     * @action Lien de vérification cliqué
     * @attendu L’événement Verified est déclenché
     */
    public function test_email_verification_link_can_be_clicked()
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        Event::fake();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        Event::assertDispatched(Verified::class);
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
        $response->assertRedirect(route('dashboard'));
    }

    /**
     * @projet CESIZen
     * @module Vérification Email
     * @responsable Équipe CESIZen
     * @action Utilisation d’un hash invalide
     * @attendu L’email n’est pas marqué comme vérifié
     */
    public function test_email_cannot_be_verified_with_invalid_hash()
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => 'wrong-hash']
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }

    /**
     * @projet CESIZen
     * @module Vérification Email
     * @responsable Équipe CESIZen
     * @action Utilisation d’un ID utilisateur invalide
     * @attendu La vérification échoue
     */
    public function test_email_cannot_be_verified_with_invalid_id()
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => 999, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }

    /**
     * @projet CESIZen
     * @module Vérification Email
     * @responsable Équipe CESIZen
     * @action Utilisation d’un lien expiré
     * @attendu L’utilisateur ne peut pas valider son email
     */
    public function test_email_cannot_be_verified_with_expired_link()
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->subMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }

    /**
     * @projet CESIZen
     * @module Vérification Email
     * @responsable Équipe CESIZen
     * @action Réenvoi du lien de vérification
     * @attendu L’utilisateur est redirigé vers la page de vérification
     */
    public function test_user_can_resend_verification_email()
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $response = $this->actingAs($user)
            ->post(route('verification.send'), [
                '_token' => csrf_token(),
            ]);

        $response = $this->get('/dashboard');
        $response->assertRedirect(route('verification.notice'));
    }
}
