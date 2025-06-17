<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * @module Articles
     * @description Affiche la liste des articles publiés par date décroissante
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $articles = Article::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(10);
            
        return view('articles.index', compact('articles'));
    }

    /**
     * @module Articles
     * @description Affiche le détail d’un article publié, ou 404 si non publié
     * @return \Illuminate\View\View|\Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        if (!$article->is_published) {
            abort(404);
        }

        return view('articles.show', compact('article'));
    }
}
