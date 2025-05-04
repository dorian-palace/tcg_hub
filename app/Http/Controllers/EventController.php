<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function create()
    {
        $games = Game::orderBy('name')->get();
        return view('events.create', compact('games'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'game_id' => 'required|exists:games,id',
                'venue_name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'state' => 'nullable|string|max:255',
                'postal_code' => 'required|string|max:20',
                'country' => 'required|string|max:255',
                'start_datetime' => 'required|date|after:now',
                'end_datetime' => 'required|date|after:start_datetime',
                'max_participants' => 'required|integer|min:2',
                'event_type' => 'required|in:tournament,casual_play,trade,release,other',
                'entry_fee' => 'nullable|numeric|min:0',
                'prizes' => 'nullable|string',
            ]);

            $event = new Event($validated);
            $event->user_id = Auth::id();
            $event->is_approved = false;
            $event->is_cancelled = false;
            
            if ($event->save()) {
                Log::info('Event created successfully', [
                    'event_id' => $event->id,
                    'user_id' => Auth::id(),
                    'title' => $event->title
                ]);

                return redirect()->route('events.show', $event->id)
                    ->with('success', 'Événement créé avec succès !');
            }

            throw new \Exception('Failed to save event');

        } catch (\Exception $e) {
            Log::error('Error creating event', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'request_data' => $request->except(['_token'])
            ]);

            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création de l\'événement. Veuillez réessayer.');
        }
    }

    public function show($id)
    {
        try {
            $event = Event::with(['game', 'user'])->findOrFail($id);
            return view('events.show', compact('event'));
        } catch (\Exception $e) {
            Log::error('Error showing event', [
                'error' => $e->getMessage(),
                'event_id' => $id
            ]);

            return redirect()->route('events.find')
                ->with('error', 'L\'événement demandé n\'existe pas ou a été supprimé.');
        }
    }
}
