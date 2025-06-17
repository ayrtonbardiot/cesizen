<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::query();
    
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('slug', 'like', '%' . $request->search . '%');
            });
        }
    
        $pages = $query->orderByDesc('created_at')->paginate(15);
    
        return view('admin.pages.index', compact('pages'));
    }
    
    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'is_visible' => $request->has('is_visible'),
        ]);
    
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|alpha_dash|unique:pages,slug',
            'content' => 'nullable|string',
            'is_visible' => 'boolean',
        ]);
    
        Page::create($data);
        return redirect()->route('admin.pages.index')->with('success', 'Page créée');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->merge([
            'is_visible' => $request->has('is_visible'),
        ]);
    
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|alpha_dash|unique:pages,slug,' . $page->id,
            'content' => 'nullable|string',
            'is_visible' => 'boolean',
        ]);
    
        $page->update($data);
        return redirect()->route('admin.pages.index')->with('success', 'Page mise à jour');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page supprimée');
    }
}
