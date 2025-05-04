<?php

namespace App\Helpers;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class EventHelper
{
    /**
     * Récupère les événements à venir
     * 
     * @param int $limit Nombre maximum d'événements à récupérer
     * @return Collection Collection d'événements
     */
    public static function getUpcomingEvents(int $limit = 10): Collection
    {
        return Event::with(['game', 'user'])
            ->where('start_datetime', '>=', now())
            ->where('is_cancelled', false)
            ->where('is_approved', true)
            ->orderBy('start_datetime')
            ->limit($limit)
            ->get();
    }

    /**
     * Récupère les événements populaires (avec le plus de participants)
     * 
     * @param int $limit Nombre maximum d'événements à récupérer
     * @return Collection Collection d'événements
     */
    public static function getPopularEvents(int $limit = 10): Collection
    {
        return Event::with(['game', 'user'])
            ->where('start_datetime', '>=', now())
            ->where('is_cancelled', false)
            ->where('is_approved', true)
            ->withCount('participants')
            ->orderByDesc('participants_count')
            ->limit($limit)
            ->get();
    }

    /**
     * Récupère les événements proches d'une position géographique
     * 
     * @param float $latitude Latitude
     * @param float $longitude Longitude
     * @param float $radius Rayon de recherche en kilomètres
     * @param int $limit Nombre maximum d'événements à récupérer
     * @return Collection Collection d'événements
     */
    public static function getNearbyEvents(float $latitude, float $longitude, float $radius = 50, int $limit = 20): Collection
    {
        // Calculer la distance avec la formule de Haversine (même logique que dans le contrôleur)
        $haversineFormula = "(6371 * acos(
            cos(radians($latitude)) * 
            cos(radians(latitude)) * 
            cos(radians(longitude) - radians($longitude)) + 
            sin(radians($latitude)) * 
            sin(radians(latitude))
        ))";
        
        return Event::with(['game', 'user'])
            ->select('*')
            ->selectRaw("{$haversineFormula} AS distance")
            ->where('start_datetime', '>=', now())
            ->where('is_cancelled', false)
            ->where('is_approved', true)
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->limit($limit)
            ->get();
    }

    /**
     * Récupère les événements organisés par un utilisateur
     * 
     * @param User $user Utilisateur
     * @param int $limit Nombre maximum d'événements à récupérer
     * @return Collection Collection d'événements
     */
    public static function getEventsByOrganizer(User $user, int $limit = 20): Collection
    {
        return Event::with(['game'])
            ->where('user_id', $user->id)
            ->orderByDesc('start_datetime')
            ->limit($limit)
            ->get();
    }

    /**
     * Récupère les événements auxquels un utilisateur participe
     * 
     * @param User $user Utilisateur
     * @param int $limit Nombre maximum d'événements à récupérer
     * @return Collection Collection d'événements
     */
    public static function getEventsForParticipant(User $user, int $limit = 20): Collection
    {
        return $user->participatingEvents()
            ->with(['game', 'user'])
            ->where('start_datetime', '>=', now())
            ->where('is_cancelled', false)
            ->orderBy('start_datetime')
            ->limit($limit)
            ->get();
    }

    /**
     * Formate la date et l'heure d'un événement
     * 
     * @param Event $event Événement
     * @param string $format Format de date (court, long, complet)
     * @return string Date et heure formatées
     */
    public static function formatEventDateTime(Event $event, string $format = 'complet'): string
    {
        $startDate = Carbon::parse($event->start_datetime);
        $endDate = Carbon::parse($event->end_datetime);
        
        switch ($format) {
            case 'court':
                return $startDate->format('d/m/Y');
            
            case 'long':
                return $startDate->format('d/m/Y à H:i');
                
            case 'complet':
            default:
                // Si même jour
                if ($startDate->isSameDay($endDate)) {
                    return $startDate->format('d/m/Y, H:i') . ' - ' . $endDate->format('H:i');
                }
                
                // Jours différents
                return $startDate->format('d/m/Y, H:i') . ' - ' . $endDate->format('d/m/Y, H:i');
        }
    }

    /**
     * Vérifie si un événement est complet (nombre max de participants atteint)
     * 
     * @param Event $event Événement
     * @return bool
     */
    public static function isEventFull(Event $event): bool
    {
        if (!$event->max_participants) {
            return false;
        }
        
        $currentParticipants = $event->participants()
            ->whereIn('status', ['registered', 'confirmed'])
            ->count();
            
        return $currentParticipants >= $event->max_participants;
    }

    /**
     * Vérifie si un événement est terminé
     * 
     * @param Event $event Événement
     * @return bool
     */
    public static function isEventEnded(Event $event): bool
    {
        return Carbon::parse($event->end_datetime)->isPast();
    }

    /**
     * Vérifie si un événement est en cours
     * 
     * @param Event $event Événement
     * @return bool
     */
    public static function isEventInProgress(Event $event): bool
    {
        $now = Carbon::now();
        $startDate = Carbon::parse($event->start_datetime);
        $endDate = Carbon::parse($event->end_datetime);
        
        return $now->isAfter($startDate) && $now->isBefore($endDate);
    }

    /**
     * Calcule le nombre de places restantes pour un événement
     * 
     * @param Event $event Événement
     * @return int|null Nombre de places restantes ou null si pas de limite
     */
    public static function getRemainingSpots(Event $event): ?int
    {
        if (!$event->max_participants) {
            return null;
        }
        
        $currentParticipants = $event->participants()
            ->whereIn('status', ['registered', 'confirmed'])
            ->count();
            
        return max(0, $event->max_participants - $currentParticipants);
    }

    /**
     * Filtre les événements selon plusieurs critères
     * 
     * @param array $filters Filtres à appliquer
     * @return Builder Builder de la requête
     */
    public static function filterEvents(array $filters): Builder
    {
        $query = Event::with(['game', 'user']);
        
        // Filtre par jeu
        if (isset($filters['game_id']) && $filters['game_id']) {
            $query->where('game_id', $filters['game_id']);
        }
        
        // Filtre par type d'événement
        if (isset($filters['event_type']) && $filters['event_type']) {
            $query->where('event_type', $filters['event_type']);
        }
        
        // Filtre par date
        if (isset($filters['start_date']) && $filters['start_date']) {
            $query->whereDate('start_datetime', '>=', $filters['start_date']);
        } else {
            // Par défaut, n'afficher que les événements futurs
            $query->where('start_datetime', '>=', now());
        }
        
        if (isset($filters['end_date']) && $filters['end_date']) {
            $query->whereDate('start_datetime', '<=', $filters['end_date']);
        }
        
        // Filtre par localisation (si latitude et longitude sont fournies)
        if (isset($filters['latitude'], $filters['longitude'], $filters['radius']) && 
            $filters['latitude'] && $filters['longitude'] && $filters['radius']) {
            
            $lat = $filters['latitude'];
            $lng = $filters['longitude'];
            $radius = $filters['radius'];
            
            $haversineFormula = "(6371 * acos(
                cos(radians($lat)) * 
                cos(radians(latitude)) * 
                cos(radians(longitude) - radians($lng)) + 
                sin(radians($lat)) * 
                sin(radians(latitude))
            ))";
            
            $query->select('*')
                  ->selectRaw("{$haversineFormula} AS distance")
                  ->having('distance', '<=', $radius);
        }
        
        // Filtre événements non annulés et approuvés
        $query->where('is_cancelled', false)
              ->where('is_approved', true);
        
        // Tri
        $sortBy = $filters['sort'] ?? 'date';
        switch ($sortBy) {
            case 'date':
                $query->orderBy('start_datetime');
                break;
                
            case 'popularity':
                $query->withCount('participants')
                      ->orderByDesc('participants_count');
                break;
                
            case 'distance':
                // Si on a calculé la distance
                if (isset($filters['latitude'], $filters['longitude'])) {
                    $query->orderBy('distance');
                } else {
                    $query->orderBy('start_datetime');
                }
                break;
                
            default:
                $query->orderBy('start_datetime');
                break;
        }
        
        return $query;
    }

    /**
     * Convertit le type d'événement en libellé lisible
     * 
     * @param string $type Type d'événement
     * @return string Libellé
     */
    public static function getEventTypeLabel(string $type): string
    {
        $types = [
            'tournament' => 'Tournoi',
            'casual_play' => 'Jeu libre',
            'trade' => 'Échange',
            'release' => 'Sortie',
            'other' => 'Autre',
        ];
        
        return $types[$type] ?? $type;
    }

    /**
     * Génère un slug unique pour un événement
     * 
     * @param string $title Titre de l'événement
     * @return string Slug unique
     */
    public static function generateUniqueSlug(string $title): string
    {
        $slug = str_slug($title);
        $originalSlug = $slug;
        $count = 1;
        
        // Vérifier si le slug existe déjà
        while (Event::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }
        
        return $slug;
    }

    /**
     * Vérifie si un utilisateur peut s'inscrire à un événement
     * 
     * @param User $user Utilisateur
     * @param Event $event Événement
     * @return bool
     */
    public static function canRegister(User $user, Event $event): bool
    {
        // Vérifier si l'événement est terminé
        if (self::isEventEnded($event)) {
            return false;
        }
        
        // Vérifier si l'événement est annulé
        if ($event->is_cancelled) {
            return false;
        }
        
        // Vérifier si l'événement est complet
        if (self::isEventFull($event)) {
            return false;
        }
        
        // Vérifier si l'utilisateur est déjà inscrit
        if (UserHelper::isEventParticipant($user, $event)) {
            return false;
        }
        
        return true;
    }
}