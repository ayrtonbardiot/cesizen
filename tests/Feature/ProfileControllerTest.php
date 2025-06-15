<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
    }

    /**
     * @projet CESIZen
     * @module Profil
     * @responsable Équipe CESIZen
     * @action Affichage du profil utilisateur
     * @attendu Le profil est visible et la vue 'profile' est rendue
     */
    public function test_user_can_view_profile()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->get(route('profile'));

        $response->assertStatus(200)
                 ->assertViewIs('profile')
                 ->assertViewHas('user', $user);
    }

    /**
     * @projet CESIZen
     * @module Profil
     * @responsable Équipe CESIZen
     * @action Mise à jour des informations du profil
     * @attendu Les données sont enregistrées et l'utilisateur est redirigé avec un message de succès
     */
    public function test_user_can_update_profile()
    {
        $user = User::factory()->create();
        $newData = [
            'name' => 'New Name',
            'email' => 'newemail@example.com',
            '_token' => csrf_token(),
        ];

        $response = $this->actingAs($user)
            ->put(route('profile.update'), $newData);

        $response->assertRedirect()
                 ->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $newData['name'],
            'email' => $newData['email'],
        ]);
    }

    /**
     * @projet CESIZen
     * @module Profil
     * @responsable Équipe CESIZen
     * @action Mise à jour du profil avec un email déjà utilisé
     * @attendu Un message d’erreur est renvoyé pour le champ email
     */
    public function test_user_cannot_update_profile_with_existing_email()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $response = $this->actingAs($user1)
            ->put(route('profile.update'), [
                'name' => 'New Name',
                'email' => $user2->email,
                '_token' => csrf_token(),
            ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * @projet CESIZen
     * @module Profil
     * @responsable Équipe CESIZen
     * @action Mise à jour du mot de passe avec les bonnes informations
     * @attendu Le mot de passe est mis à jour avec succès
     */
    public function test_user_can_update_password()
    {
        $user = User::factory()->create(['password' => Hash::make('password123')]);
        $newPassword = 'newpassword123';

        $response = $this->actingAs($user)
            ->put(route('profile.password'), [
                'current_password' => 'password123',
                'password' => $newPassword,
                'password_confirmation' => $newPassword,
                '_token' => csrf_token(),
            ]);

        $response->assertRedirect()
                 ->assertSessionHas('success');
    }

    /**
     * @projet CESIZen
     * @module Profil
     * @responsable Équipe CESIZen
     * @action Échec de la mise à jour du mot de passe (mot de passe actuel incorrect)
     * @attendu Un message d’erreur est renvoyé pour le champ 'current_password'
     */
    public function test_user_cannot_update_password_with_wrong_current_password()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->put(route('profile.password'), [
                'current_password' => 'wrongpassword',
                'password' => 'newpassword123',
                'password_confirmation' => 'newpassword123',
                '_token' => csrf_token(),
            ]);

        $response->assertSessionHasErrors('current_password');
    }

    /**
     * @projet CESIZen
     * @module Profil
     * @responsable Équipe CESIZen
     * @action Téléchargement des données personnelles
     * @attendu Un fichier JSON contenant les données utilisateur est généré
     */
    public function test_user_can_download_personal_data()
    {
        $user = User::factory()->create();
    
        $response = $this->actingAs($user)
            ->get(route('profile.download-data'));
    
        $response->assertStatus(200)
                 ->assertHeader('Content-Disposition', 'attachment; filename=cesizen_personaldata.json');
    
        $files = Storage::disk('local')->allFiles('tmp');
        $this->assertNotEmpty($files, "Aucun fichier temporaire n'a été généré dans /tmp");

        $json = Storage::disk('local')->get($files[0]);
        $data = json_decode($json, true);

        $this->assertEquals($user->id, $data['user']['id']);
        $this->assertEquals($user->email, $data['user']['email']);
    }
}