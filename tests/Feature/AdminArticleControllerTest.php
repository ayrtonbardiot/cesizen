<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    private function admin()
    {
        /** @var User $admin */
        return User::factory()->create(['role' => 'admin']);
    }

    /**
     * @projet CESIZen
     * @module Articles (Admin)
     * @responsable Équipe CESIZen
     * @action Accéder à l'index des articles
     * @attendu L'admin accède à la vue 'admin.articles.index'
     */
    public function test_admin_can_see_articles_index()
    {
        $admin = $this->admin();
        $response = $this->actingAs($admin)->get(route('admin.articles.index'));
        $response->assertStatus(200)->assertViewIs('admin.articles.index');
    }

    /**
     * @projet CESIZen
     * @module Articles (Admin)
     * @responsable Équipe CESIZen
     * @action Accéder au formulaire de création
     * @attendu La vue 'admin.articles.create' est affichée
     */
    public function test_admin_can_see_create_form()
    {
        $admin = $this->admin();
        $response = $this->actingAs($admin)->get(route('admin.articles.create'));
        $response->assertStatus(200)->assertViewIs('admin.articles.create');
    }

    /**
     * @projet CESIZen
     * @module Articles (Admin)
     * @responsable Équipe CESIZen
     * @action Créer un article
     * @attendu L'article est sauvegardé et l'utilisateur est redirigé
     */
    public function test_admin_can_store_article()
    {
        Storage::fake('public');
        $admin = $this->admin();
        $article = Article::factory()->make();

        $data = [
            'title' => $article->title,
            'content' => $article->content,
            'author' => $article->author,
            'is_published' => true,
        ];

        $response = $this->actingAs($admin)->post(route('admin.articles.store'), $data);
        $response->assertRedirect(route('admin.articles.index'));

        $this->assertDatabaseHas('articles', [
            'title' => $article->title,
        ]);
    }

    /**
     * @projet CESIZen
     * @module Articles (Admin)
     * @responsable Équipe CESIZen
     * @action Modifier un article
     * @attendu Le formulaire d'édition est affiché avec l'article concerné
     */
    public function test_admin_can_edit_article()
    {
        $admin = $this->admin();
        $article = Article::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.articles.edit', $article));
        $response->assertStatus(200)
            ->assertViewIs('admin.articles.edit')
            ->assertViewHas('article', $article);
    }

    /**
     * @projet CESIZen
     * @module Articles (Admin)
     * @responsable Équipe CESIZen
     * @action Mettre à jour un article
     * @attendu L'article est mis à jour et l'utilisateur est redirigé
     */
    public function test_admin_can_update_article()
    {
        $admin = $this->admin();
        $article = Article::factory()->create();
        $newData = [
            'title' => 'Nouveau titre',
            'content' => 'Nouveau contenu',
            'author' => 'Nouvel auteur',
            'is_published' => true,
        ];

        $response = $this->actingAs($admin)->put(route('admin.articles.update', $article), $newData);
        $response->assertRedirect(route('admin.articles.index'));

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => 'Nouveau titre',
        ]);
    }

    /**
     * @projet CESIZen
     * @module Articles (Admin)
     * @responsable Équipe CESIZen
     * @action Supprimer un article
     * @attendu L'article est supprimé et l'utilisateur est redirigé
     */
    public function test_admin_can_delete_article()
    {
        $admin = $this->admin();
        $article = Article::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.articles.destroy', $article));
        $response->assertRedirect(route('admin.articles.index'));

        $this->assertSoftDeleted('articles', [
            'id' => $article->id
        ]);
    }

    /**
     * @projet CESIZen
     * @module Articles (Admin)
     * @responsable Équipe CESIZen
     * @action Restaurer un article
     * @attendu L'article est restauré et l'utilisateur est redirigé
     */
    public function test_admin_can_restore_article()
    {
        $admin = $this->admin();
        $article = Article::factory()->create();
        $article->delete();

        $response = $this->actingAs($admin)->post(route('admin.articles.restore', $article->id));
        $response->assertRedirect(route('admin.articles.index'));

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'deleted_at' => null
        ]);
    }

    /**
     * @projet CESIZen
     * @module Articles (Admin)
     * @responsable Équipe CESIZen
     * @action Supprimer définitivement un article
     * @attendu L'article est supprimé définitivement et l'utilisateur est redirigé
     */
    public function test_admin_can_force_delete_article()
    {
        $admin = $this->admin();
        $article = Article::factory()->create();
        $article->delete();

        $response = $this->actingAs($admin)->delete(route('admin.articles.force-delete', $article->id));
        $response->assertRedirect(route('admin.articles.index'));

        $this->assertDatabaseMissing('articles', [
            'id' => $article->id
        ]);
    }
} 