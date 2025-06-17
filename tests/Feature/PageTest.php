<?php

namespace Tests\Feature;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @projet CESIZen
     * @module Pages statiques
     * @responsable Équipe CESIZen
     * @action Un visiteur accède à une page visible
     * @attendu La page est affichée avec son contenu
     */
    public function test_can_show_visible_page()
    {
        $page = Page::factory()->create([
            'slug' => 'a-propos',
            'is_visible' => true,
            'title' => 'À propos',
            'content' => 'Contenu à propos',
        ]);

        $response = $this->get('/pages/' . $page->slug);

        $response->assertStatus(200)
                 ->assertViewIs('page')
                 ->assertViewHas('page')
                 ->assertSee($page->title)
                 ->assertSee($page->content);
    }

    /**
     * @projet CESIZen
     * @module Pages statiques
     * @responsable Équipe CESIZen
     * @action Un visiteur tente d'accéder à une page non visible
     * @attendu L'accès est refusé avec une erreur 404
     */
    public function test_cannot_show_invisible_page()
    {
        $page = Page::factory()->create([
            'slug' => 'terms',
            'is_visible' => false,
        ]);

        $response = $this->get('/pages/' . $page->slug);

        $response->assertStatus(404);
    }

    /**
     * @projet CESIZen
     * @module Pages statiques
     * @responsable Équipe CESIZen
     * @action Un visiteur tente d’accéder à une page inexistante
     * @attendu Une erreur 404 est retournée
     */
    public function test_returns_404_if_page_not_found()
    {
        $response = $this->get('/pages/non-existante');
        $response->assertStatus(404);
    }
}
