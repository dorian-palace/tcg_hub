<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Facades\CardHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CollectionController extends Controller
{
    /**
     * Display a listing of collection items.
     */
    public function index(Request $request)
    {
        // Default to current user if not specified
        $userId = $request->user_id ?? Auth::id();
        
        // Check if we have permission to view this collection
        if ($userId != Auth::id() && !Auth::user()->isAdmin()) {
            // Check if the collection is public
            // For now, we'll just allow viewing any collection
        }
        
        // Get filters from request
        $filters = [
            'user_id' => $userId,
            'game_id' => $request->game_id,
            'set' => $request->set,
            'rarity' => $request->rarity,
            'condition' => $request->condition,
            'for_sale' => $request->has('for_sale') ? filter_var($request->for_sale, FILTER_VALIDATE_BOOLEAN) : null,
            'for_trade' => $request->has('for_trade') ? filter_var($request->for_trade, FILTER_VALIDATE_BOOLEAN) : null,
            'search' => $request->search,
        ];
        
        // Use our CardHelper facade to filter collection
        $collection = CardHelper::filterCollection($filters);
        
        return response()->json($collection);
    }

    /**
     * Store a newly created collection item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'card_id' => 'required|exists:cards,id',
            'quantity' => 'required|integer|min:1',
            'condition' => 'required|in:mint,near_mint,excellent,good,played,poor',
            'for_sale' => 'sometimes|boolean',
            'for_trade' => 'sometimes|boolean',
            'price' => 'required_if:for_sale,true|nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);
        
        // Check if we already have this card in our collection
        $existingItem = Collection::where('user_id', Auth::id())
            ->where('card_id', $validated['card_id'])
            ->where('condition', $validated['condition'])
            ->first();
            
        if ($existingItem) {
            // Update quantity of existing item
            $existingItem->quantity += $validated['quantity'];
            
            // Update other fields if provided
            if (isset($validated['for_sale'])) {
                $existingItem->for_sale = $validated['for_sale'];
            }
            
            if (isset($validated['for_trade'])) {
                $existingItem->for_trade = $validated['for_trade'];
            }
            
            if (isset($validated['price'])) {
                $existingItem->price = $validated['price'];
            }
            
            if (isset($validated['notes'])) {
                $existingItem->notes = $validated['notes'];
            }
            
            $existingItem->save();
            
            return response()->json($existingItem);
        }
        
        // Create new collection item
        $collectionItem = Collection::create([
            'user_id' => Auth::id(),
            'card_id' => $validated['card_id'],
            'quantity' => $validated['quantity'],
            'condition' => $validated['condition'],
            'for_sale' => $validated['for_sale'] ?? false,
            'for_trade' => $validated['for_trade'] ?? false,
            'price' => $validated['price'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);
        
        return response()->json($collectionItem, 201);
    }

    /**
     * Display the specified collection item.
     */
    public function show(string $id)
    {
        $item = Collection::with('card')->findOrFail($id);
        
        // Check if we have permission to view this collection item
        if ($item->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            // For now, allow viewing any collection item
        }
        
        return response()->json($item);
    }

    /**
     * Update the specified collection item.
     */
    public function update(Request $request, string $id)
    {
        $item = Collection::findOrFail($id);
        
        // Check if we have permission to update this collection item
        if ($item->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $validated = $request->validate([
            'quantity' => 'sometimes|integer|min:1',
            'condition' => 'sometimes|in:mint,near_mint,excellent,good,played,poor',
            'for_sale' => 'sometimes|boolean',
            'for_trade' => 'sometimes|boolean',
            'price' => 'required_if:for_sale,true|nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);
        
        // Update the item
        $item->update($validated);
        
        return response()->json($item);
    }

    /**
     * Remove the specified collection item.
     */
    public function destroy(string $id)
    {
        $item = Collection::findOrFail($id);
        
        // Check if we have permission to delete this collection item
        if ($item->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        // Use our CardHelper facade to check if the item can be deleted
        if (!CardHelper::canDeleteCollectionItem($item)) {
            return response()->json(['message' => 'Cannot delete item that is part of pending transactions'], 403);
        }
        
        $item->delete();
        
        return response()->json(null, 204);
    }
}
