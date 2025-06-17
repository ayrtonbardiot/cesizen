<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    /**
     * @module Pages statiques
     * @description Affiche une page statique si elle est marquée comme visible
     * @return \Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function show(Page $page)
    {
        abort_unless($page->is_visible, 404);
        return view('page', compact('page'));
    }
}