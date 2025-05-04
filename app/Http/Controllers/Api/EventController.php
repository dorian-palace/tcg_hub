<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Event::with(['game:id,name', 'user:id,name,email'])
                    ->where('is_cancelled', false)
                    ->where('start_datetime', '>=', now());
                    
        // Apply game filter if provided
        if ($request->filled('game_id')) {
            $query->where('game_id', $request->game_id);
        }
        
        // Apply event type filter if provided
        if ($request->filled('event_type')) {
            $query->where('event_type', $request->event_type);
        }
        
        // Apply date filter if provided
        if ($request->filled('start_date')) {
            $query->whereDate('start_datetime', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('start_datetime', '<=', $request->end_date);
        }
        
        // Apply sorting
        $sortBy = $request->input('sort', 'start_datetime');
        $sortDir = $request->input('direction', 'asc');
        
        $query->orderBy($sortBy, $sortDir);
        
        // Paginate results
        $events = $query->paginate(15);
        
        return response()->json($events);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = \App\Models\Event::with([
            'game',
            'user:id,name,email,phone',
            'participants:id,name,email' => function($query) {
                $query->wherePivot('status', '!=', 'cancelled')
                      ->orderBy('name');
            }
        ])->findOrFail($id);
        
        // Get participant count
        $event->participant_count = $event->participants->count();
        
        // Check if it's full
        $event->is_full = false;
        if ($event->max_participants && $event->participant_count >= $event->max_participants) {
            $event->is_full = true;
        }
        
        return response()->json($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
