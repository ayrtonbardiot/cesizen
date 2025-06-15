<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BreathingExercise;
use App\Models\BreathingCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BreathingExerciseController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BreathingExercise::with('category');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $category = $request->get('category');
            $query->where('category_id', $category);
        }

        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $exercises = $query->latest()->paginate(10);
        $categories = BreathingCategory::all();

        return view('admin.breathing.index', compact('exercises', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BreathingCategory::all();
        return view('admin.breathing.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:breathing_categories,id'],
            'image' => ['nullable', 'image', 'max:2048'],
            'steps' => ['required', 'array', 'min:1'],
            'steps.*.type' => ['required', 'string', Rule::in(['inspire', 'expire', 'repeat', 'hold', 'instruction'])],
            'steps.*.duration' => ['required', 'integer', 'min:1'],
            'is_active' => ['boolean'],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('breathing-exercises', 'public');
            $validated['image'] = $path;
        }

        $exercise = BreathingExercise::create($validated);

        return redirect()
            ->route('admin.breathing.index')
            ->with('success', __('messages.admin.breathing.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(BreathingExercise $breathing)
    {
        return view('admin.breathing.show', compact('breathing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BreathingExercise $breathing)
    {
        $categories = BreathingCategory::all();
        return view('admin.breathing.edit', compact('breathing', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BreathingExercise $breathing)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:breathing_categories,id'],
            'image' => ['nullable', 'image', 'max:2048'],
            'steps' => ['required', 'array', 'min:1'],
            'steps.*.type' => ['required', 'string', Rule::in(['inspire', 'expire', 'repeat', 'hold', 'instruction'])],
            'steps.*.duration' => ['required', 'integer', 'min:1'],
            'is_active' => ['boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($breathing->image) {
                Storage::disk('public')->delete($breathing->image);
            }
            $path = $request->file('image')->store('breathing-exercises', 'public');
            $validated['image'] = $path;
        }

        $breathing->update($validated);

        return redirect()
            ->route('admin.breathing.index')
            ->with('success', __('messages.admin.breathing.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BreathingExercise $breathing)
    {
        if ($breathing->image) {
            Storage::disk('public')->delete($breathing->image);
        }

        $breathing->delete();

        return redirect()
            ->route('admin.breathing.index')
            ->with('success', __('messages.admin.breathing.deleted'));
    }
}
