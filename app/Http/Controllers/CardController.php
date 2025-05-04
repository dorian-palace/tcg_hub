<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Display a listing of the cards.
     */
    public function index(Request $request)
    {
        // Get all games for the filter dropdown
        $games = Game::orderBy('name')->get();
        
        // Build the card query
        $query = Card::query();
        
        // Apply game filter if provided
        if ($request->filled('game_id')) {
            $query->where('game_id', $request->game_id);
        }
        
        // Apply set filter if provided
        if ($request->filled('set')) {
            $query->where('set_name', 'like', "%{$request->set}%");
        }
        
        // Apply search filter if provided
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Get paginated cards
        $cards = $query->orderBy('name')->paginate(12);
        
        return view('cards.index', compact('games', 'cards'));
    }
} 