<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(10);
            
        return view('articles.index', compact('articles'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        if (!$article->is_published) {
            abort(404);
        }
        
        return view('articles.show', compact('article'));
    }
}
