<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPageControllerTest extends TestCase
{
    use RefreshDatabase;

    private function admin()
    {
        return User::factory()->create(['role' => 'admin']);
    }

    /**
     * @projet CESIZen
     * @module Pages statiques (Admin)
     * @responsable Équipe CESIZen
     * @action Accéder à l’index des pages
     * @attendu L’admin accède à la vue 'admin.pages.index'
     */
    public function test_admin_can_see_pages_index()
    {
        $admin = $this->admin();
        $response = $this->actingAs($admin)->get(route('admin.pages.index'));
        $response->assertStatus(200)->assertViewIs('admin.pages.index');
    }

    /**
     * @projet CESIZen
     * @module Pages statiques (Admin)
     * @responsable Équipe CESIZen
     * @action Accéder au formulaire de création
     * @attendu La vue 'admin.pages.create' est affichée
     */
    public function test_admin_can_see_create_form()
    {
        $admin = $this->admin();
        $response = $this->actingAs($admin)->get(route('admin.pages.create'));
        $response->assertStatus(200)->assertViewIs('admin.pages.create');
    }

    /**
     * @projet CESIZen
     * @module Pages statiques (Admin)
     * @responsable Équipe CESIZen
     * @action Créer une page
     * @attendu La page est sauvegardée et redirigée
     */
    public function test_admin_can_store_page()
    {
        $admin = $this->admin();
        $data = [
            'title' => 'À propos',
            'slug' => 'a-propos',
            'content' => 'Contenu test',
            'is_visible' => true,
        ];

        $response = $this->actingAs($admin)->post(route('admin.pages.store'), $data);
        $response->assertRedirect(route('admin.pages.index'));
        $this->assertDatabaseHas('pages', ['title' => 'À propos']);
    }

    /**
     * @projet CESIZen
     * @module Pages statiques (Admin)
     * @responsable Équipe CESIZen
     * @action Accéder au formulaire d’édition
     * @attendu La vue 'admin.pages.edit' est affichée avec la page
     */
    public function test_admin_can_edit_page()
    {
        $admin = $this->admin();
        $page = Page::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.pages.edit', $page));
        $response->assertStatus(200)
            ->assertViewIs('admin.pages.edit')
            ->assertViewHas('page', $page);
    }

    /**
     * @projet CESIZen
     * @module Pages statiques (Admin)
     * @responsable Équipe CESIZen
     * @action Mettre à jour une page
     * @attendu La page est mise à jour
     */
    public function test_admin_can_update_page()
    {
        $admin = $this->admin();
        $page = Page::factory()->create();

        $data = [
            'title' => 'Conditions',
            'slug' => 'conditions',
            'content' => 'Nouveau contenu',
            'is_visible' => false,
        ];

        $response = $this->actingAs($admin)->put(route('admin.pages.update', $page), $data);
        $response->assertRedirect(route('admin.pages.index'));
        $this->assertDatabaseHas('pages', ['id' => $page->id, 'title' => 'Conditions']);
    }

    /**
     * @projet CESIZen
     * @module Pages statiques (Admin)
     * @responsable Équipe CESIZen
     * @action Supprimer une page
     * @attendu La page est supprimée
     */
    public function test_admin_can_delete_page()
    {
        $admin = $this->admin();
        $page = Page::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.pages.destroy', $page));
        $response->assertRedirect(route('admin.pages.index'));
        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
    }
}
