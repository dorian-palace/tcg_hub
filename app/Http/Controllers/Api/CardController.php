<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Facades\CardHelper;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get filters from request
        $filters = [
            'game_id' => $request->game_id,
            'set' => $request->set,
            'rarity' => $request->rarity,
            'search' => $request->search,
        ];
        
        // Use our CardHelper facade to filter cards
        $cards = CardHelper::filterCards($filters);
        
        return response()->json($cards);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'game_id' => 'required|exists:games,id',
            'set' => 'required|string|max:255',
            'rarity' => 'required|string|max:50',
            'image_url' => 'nullable|url',
            'description' => 'nullable|string',
        ]);
        
        // Use our CardHelper facade to create a new card
        $card = CardHelper::createCard($validated);
        
        return response()->json($card, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $card = Card::findOrFail($id);
        
        // Get available card counts using our CardHelper
        $availability = CardHelper::getCardAvailability($card);
        
        $card->availability = $availability;
        
        return response()->json($card);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $card = Card::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'game_id' => 'sometimes|exists:games,id',
            'set' => 'sometimes|string|max:255',
            'rarity' => 'sometimes|string|max:50',
            'image_url' => 'nullable|url',
            'description' => 'nullable|string',
        ]);
        
        // Use our CardHelper facade to update the card
        $updatedCard = CardHelper::updateCard($card, $validated);
        
        return response()->json($updatedCard);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $card = Card::findOrFail($id);
        
        // Check if the card can be deleted using our CardHelper
        if (!CardHelper::canDeleteCard($card)) {
            return response()->json(['message' => 'Cannot delete card that is part of collections'], 403);
        }
        
        $card->delete();
        
        return response()->json(null, 204);
    }
}
