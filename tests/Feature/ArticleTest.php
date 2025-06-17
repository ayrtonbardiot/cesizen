<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @projet CESIZen
     * @module Articles
     * @responsable Équipe CESIZen
     * @action Un visiteur accède à la liste des articles
     * @attendu La page liste les articles publiés uniquement
     */
    public function test_can_list_published_articles()
    {
        // Create some published and unpublished articles
        Article::factory()->count(3)->published()->create();
        Article::factory()->count(2)->unpublished()->create();

        $response = $this->get(route('articles.index'));

        $response->assertStatus(200)
                ->assertViewIs('articles.index')
                ->assertViewHas('articles')
                ->assertSee('articles');
    }

    /**
     * @projet CESIZen
     * @module Articles
     * @responsable Équipe CESIZen
     * @action Un visiteur accède au détail d'un article publié
     * @attendu La page affiche les détails complets de l'article
     */
    public function test_can_show_article_details()
    {
        $article = Article::factory()->published()->create();

        $response = $this->get(route('articles.show', $article->slug));

        $response->assertStatus(200)
                ->assertViewIs('articles.show')
                ->assertViewHas('article')
                ->assertSee($article->title)
                ->assertSeeHtml($article->content);
    }

    /**
     * @projet CESIZen
     * @module Articles
     * @responsable Équipe CESIZen
     * @action Un visiteur tente d'accéder à un article non publié
     * @attendu L'accès est refusé avec une erreur 404
     */
    public function test_cannot_show_unpublished_article()
    {
        $article = Article::factory()->unpublished()->create();

        $response = $this->get(route('articles.show', $article->slug));

        $response->assertStatus(404);
    }
} 