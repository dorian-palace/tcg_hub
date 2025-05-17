<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forum;
use App\Models\Game;
use Illuminate\Support\Str;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Forum::with(['game', 'topics'])
            ->where('is_active', true);

        // Tri par game_id si spécifié
        if ($request->filled('game_id')) {
            $query->where('game_id', $request->game_id);
        }

        // Tri par catégorie si spécifiée
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $forums = $query->orderBy('order')
            ->get()
            ->groupBy('game.name');

        $games = Game::all();
        $categories = array_keys(Forum::CATEGORIES);

        return view('forums.index', compact('forums', 'games', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $games = Game::all();
        return view('forums.create', compact('games'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'game_id' => 'required|exists:games,id',
            'order' => 'nullable|integer',
            'category' => 'required|string|in:' . implode(',', array_keys(Forum::CATEGORIES))
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = true;

        Forum::create($validated);

        return redirect()->route('forums.index')
            ->with('success', 'Forum créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Forum $forum)
    {
        $topics = $forum->topics()
            ->with(['user', 'posts'])
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('forums.show', compact('forum', 'topics'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Forum $forum)
    {
        $games = Game::all();
        return view('forums.edit', compact('forum', 'games'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Forum $forum)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'game_id' => 'required|exists:games,id',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $forum->update($validated);

        return redirect()->route('forums.index')
            ->with('success', 'Forum mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Forum $forum)
    {
        $forum->delete();

        return redirect()->route('forums.index')
            ->with('success', 'Forum supprimé avec succès.');
    }
}
