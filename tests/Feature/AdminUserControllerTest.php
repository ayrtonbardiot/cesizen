<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserControllerTest extends TestCase
{
    use RefreshDatabase;

    private function admin() {
        /** @var User $admin */
        return User::factory()->create(['role' => 'admin']);
    }

    /**
     * @projet CESIZen
     * @module Gestion des utilisateurs
     * @responsable Équipe CESIZen
     * @action Affichage de la liste des utilisateurs
     * @attendu L’administrateur voit la vue 'admin.users.index' avec statut 200
     */
    public function test_admin_can_see_users_index()
    {
        $admin = $this->admin();
        $response = $this->actingAs($admin)->get(route('admin.users.index'));
        $response->assertStatus(200)
            ->assertViewIs('admin.users.index');
    }

    /**
     * @projet CESIZen
     * @module Gestion des utilisateurs
     * @responsable Équipe CESIZen
     * @action Accès au formulaire de création d’un utilisateur
     * @attendu L’administrateur accède à la vue 'admin.users.create' avec statut 200
     */
    public function test_admin_can_create_user()
    {
        $admin = $this->admin();
        $response = $this->actingAs($admin)->get(route('admin.users.create'));
        $response->assertStatus(200)
            ->assertViewIs('admin.users.create');
    }

    /**
     * @projet CESIZen
     * @module Gestion des utilisateurs
     * @responsable Équipe CESIZen
     * @action Création d’un utilisateur avec des données valides
     * @attendu L’utilisateur est créé et redirigé vers la liste, les données sont présentes en base
     */
    public function test_admin_can_store_user()
    {
        $admin = $this->admin();
        $data = [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'utilisateur',
            '_token' => csrf_token(),
        ];
        $response = $this->actingAs($admin)
            ->post(route('admin.users.store'), $data);
        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
            'role' => 'utilisateur',
        ]);
    }

    /**
     * @projet CESIZen
     * @module Gestion des utilisateurs
     * @responsable Équipe CESIZen
     * @action Accès au formulaire de modification d’un utilisateur existant
     * @attendu L’administrateur voit la vue 'admin.users.edit' avec les données de l’utilisateur
     */
    public function test_admin_can_edit_user()
    {
        $admin = $this->admin();
        $user = User::factory()->create();
        $response = $this->actingAs($admin)->get(route('admin.users.edit', $user));
        $response->assertStatus(200)
            ->assertViewIs('admin.users.edit')
            ->assertViewHas('user', $user);
    }

    /**
     * @projet CESIZen
     * @module Gestion des utilisateurs
     * @responsable Équipe CESIZen
     * @action Mise à jour des informations d’un utilisateur
     * @attendu L’utilisateur est modifié, la base contient les nouvelles informations
     */
    public function test_admin_can_update_user()
    {
        $admin = $this->admin();
        $user = User::factory()->create();
        $data = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'role' => 'utilisateur',
            '_token' => csrf_token(),
        ];
        $response = $this->actingAs($admin)
            ->put(route('admin.users.update', $user), $data);
        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }

    /**
     * @projet CESIZen
     * @module Gestion des utilisateurs
     * @responsable Équipe CESIZen
     * @action Suppression d’un utilisateur autre que soi-même
     * @attendu L’utilisateur est supprimé et absent de la base, avec redirection vers l’index
     */
    public function test_admin_can_delete_user()
    {
        $admin = $this->admin();
        $user = User::factory()->create();
        $response = $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $user));
        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }

    /**
     * @projet CESIZen
     * @module Gestion des utilisateurs
     * @responsable Équipe CESIZen
     * @action Tentative de suppression de son propre compte
     * @attendu La suppression échoue, l’utilisateur est toujours en base et un message d’erreur est retourné
     */
    public function test_admin_cannot_delete_self()
    {
        $admin = $this->admin();
        $response = $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $admin));
        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', [
            'id' => $admin->id
        ]);
    }
}
