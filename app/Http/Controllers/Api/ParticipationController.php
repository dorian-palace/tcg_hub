<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Participation;
use App\Facades\EventHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ParticipationController extends Controller
{
    /**
     * Display a listing of participations.
     */
    public function index(Request $request)
    {
        // Filter by event if provided
        if ($request->filled('event_id')) {
            $participations = Participation::with(['user', 'event'])
                ->where('event_id', $request->event_id)
                ->paginate(20);
        } 
        // Filter by user if provided (default to current user)
        else {
            $userId = $request->filled('user_id') ? $request->user_id : Auth::id();
            
            $participations = Participation::with(['event', 'event.game'])
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        }
        
        return response()->json($participations);
    }

    /**
     * Store a newly created participation (register for an event).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'notes' => 'nullable|string',
        ]);
        
        // Get the event
        $event = Event::findOrFail($validated['event_id']);
        
        // Check if the event is full
        if (EventHelper::isEventFull($event)) {
            return response()->json(['message' => 'This event is full'], 400);
        }
        
        // Check if already registered
        $existingParticipation = Participation::where('user_id', Auth::id())
            ->where('event_id', $validated['event_id'])
            ->first();
            
        if ($existingParticipation) {
            return response()->json(['message' => 'You are already registered for this event'], 400);
        }
        
        // Create the participation
        $participation = Participation::create([
            'user_id' => Auth::id(),
            'event_id' => $validated['event_id'],
            'status' => 'registered',
            'registration_date' => now(),
            'payment_received' => false,
            'notes' => $validated['notes'] ?? null,
        ]);
        
        return response()->json($participation, 201);
    }

    /**
     * Display the specified participation.
     */
    public function show(string $id)
    {
        $participation = Participation::with(['user', 'event'])->findOrFail($id);
        
        // Check if the user has permission to view this participation
        if (Auth::id() !== $participation->user_id && 
            Auth::id() !== $participation->event->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        return response()->json($participation);
    }

    /**
     * Update the specified participation.
     */
    public function update(Request $request, string $id)
    {
        $participation = Participation::findOrFail($id);
        
        // Check if the user has permission to update this participation
        // Participants can only update their own participation notes
        // Event organizers can update status, payment, ranking
        if (Auth::id() === $participation->user_id) {
            // Participant updating their own participation
            $validated = $request->validate([
                'notes' => 'nullable|string',
            ]);
            
            $participation->update([
                'notes' => $validated['notes'] ?? $participation->notes,
            ]);
        } 
        elseif (Auth::id() === $participation->event->user_id) {
            // Event organizer updating a participation
            $validated = $request->validate([
                'status' => 'sometimes|in:registered,confirmed,cancelled,attended',
                'payment_received' => 'sometimes|boolean',
                'final_ranking' => 'nullable|integer|min:1',
                'notes' => 'nullable|string',
            ]);
            
            $participation->update($validated);
        } 
        else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        return response()->json($participation);
    }

    /**
     * Remove the specified participation (cancel registration).
     */
    public function destroy(string $id)
    {
        $participation = Participation::findOrFail($id);
        
        // Check if the user has permission to delete this participation
        if (Auth::id() !== $participation->user_id && 
            Auth::id() !== $participation->event->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        // Instead of actually deleting, set status to cancelled
        $participation->update(['status' => 'cancelled']);
        
        return response()->json(null, 204);
    }
}
