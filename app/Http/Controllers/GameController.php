<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Card;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GameController extends Controller
{
    /**
     * Display a listing of the games.
     */
    public function index(Request $request)
    {
        $query = Game::query();
        
        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $games = $query->orderBy('name')->paginate(12);
        
        return view('games.index', compact('games'));
    }

    /**
     * Show the form for creating a new game.
     */
    public function create()
    {
        return view('games.create');
    }

    /**
     * Store a newly created game in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:games',
            'publisher' => 'required|string|max:255',
            'release_date' => 'nullable|date',
            'description' => 'required|string',
            'website_url' => 'nullable|url|max:255',
            'image' => 'nullable|image|max:2048', // 2MB max
        ]);
        
        $game = new Game();
        $game->name = $validated['name'];
        $game->publisher = $validated['publisher'];
        
        if (isset($validated['release_date'])) {
            $game->release_date = $validated['release_date'];
        }
        
        $game->description = $validated['description'];
        
        if (isset($validated['website_url'])) {
            $game->website_url = $validated['website_url'];
        }
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('games', 'public');
            $game->image_url = Storage::url($path);
        }
        
        $game->save();
        
        return redirect()->route('games.show', $game)
                        ->with('success', 'Game created successfully.');
    }

    /**
     * Display the specified game.
     */
    public function show(Game $game)
    {
        // Get latest cards for this game
        $latestCards = Card::where('game_id', $game->id)
                         ->orderBy('created_at', 'desc')
                         ->take(8)
                         ->get();
        
        // Get upcoming events for this game
        $upcomingEvents = Event::where('game_id', $game->id)
                            ->where('start_datetime', '>=', now())
                            ->orderBy('start_datetime')
                            ->take(3)
                            ->get();
        
        return view('games.show', compact('game', 'latestCards', 'upcomingEvents'));
    }

    /**
     * Show the form for editing the specified game.
     */
    public function edit(Game $game)
    {
        return view('games.edit', compact('game'));
    }

    /**
     * Update the specified game in storage.
     */
    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:games,name,'.$game->id,
            'publisher' => 'required|string|max:255',
            'release_date' => 'nullable|date',
            'description' => 'required|string',
            'website_url' => 'nullable|url|max:255',
            'image' => 'nullable|image|max:2048', // 2MB max
        ]);
        
        $game->name = $validated['name'];
        $game->publisher = $validated['publisher'];
        
        if (isset($validated['release_date'])) {
            $game->release_date = $validated['release_date'];
        }
        
        $game->description = $validated['description'];
        
        if (isset($validated['website_url'])) {
            $game->website_url = $validated['website_url'];
        }
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($game->image_url && Str::startsWith($game->image_url, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $game->image_url);
                Storage::disk('public')->delete($oldPath);
            }
            
            $path = $request->file('image')->store('games', 'public');
            $game->image_url = Storage::url($path);
        }
        
        $game->save();
        
        return redirect()->route('games.show', $game)
                        ->with('success', 'Game updated successfully.');
    }

    /**
     * Remove the specified game from storage.
     */
    public function destroy(Game $game)
    {
        // Delete game image if exists
        if ($game->image_url && Str::startsWith($game->image_url, '/storage/')) {
            $path = str_replace('/storage/', '', $game->image_url);
            Storage::disk('public')->delete($path);
        }
        
        // Delete the game
        $game->delete();
        
        return redirect()->route('games.index')
                        ->with('success', 'Game deleted successfully.');
    }
}