<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Facades\EventHelper;
use App\Facades\UserHelper;
use Illuminate\Http\Request;

class EventSearchController extends Controller
{
    /**
     * Search for events based on location and other filters
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'required|numeric|min:1|max:500',
            'game_id' => 'nullable|exists:games,id',
            'event_type' => 'nullable|in:tournament,casual_play,trade,release,other',
            'sort' => 'nullable|in:distance,date,popularity',
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d',
        ]);
        
        // Use our EventHelper facade to find nearby events
        $events = EventHelper::findNearbyEvents(
            $request->latitude,
            $request->longitude,
            $request->radius,
            [
                'game_id' => $request->game_id,
                'event_type' => $request->event_type,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'sort' => $request->input('sort', 'distance'),
            ]
        );
        
        // Format the distance for display using our helper
        $events->getCollection()->transform(function ($event) {
            $event->formatted_distance = EventHelper::formatDistance($event->distance);
            $event->formatted_date = EventHelper::formatEventDate($event->start_datetime);
            
            // Add venue details using our UserHelper facade
            if ($event->user) {
                $event->venue_details = UserHelper::getVenueDetails($event->user);
            }
            
            // Check if the event is full
            $event->is_full = EventHelper::isEventFull($event);
            
            return $event;
        });

        return response()->json($events);
    }
}