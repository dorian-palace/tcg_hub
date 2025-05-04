<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserHelper
{
    /**
     * Génère un avatar pour un utilisateur avec Gravatar ou une image par défaut
     *
     * @param string $email Email de l'utilisateur
     * @param int $size Taille de l'avatar en pixels
     * @return string URL de l'avatar
     */
    public static function getAvatar(string $email, int $size = 80): string
    {
        $hash = md5(strtolower(trim($email)));
        return "https://www.gravatar.com/avatar/{$hash}?s={$size}&d=mp";
    }

    /**
     * Génère une URL de profil pour un utilisateur
     * 
     * @param User $user Utilisateur
     * @return string URL du profil
     */
    public static function getProfileUrl(User $user): string
    {
        return route('profile', ['id' => $user->id]);
    }

    /**
     * Vérifie si un utilisateur est administrateur
     * 
     * @param User $user Utilisateur
     * @return bool
     */
    public static function isAdmin(User $user): bool
    {
        // À implémenter avec un système de rôles
        return $user->email === 'admin@tcghub.com';
    }

    /**
     * Vérifie si un utilisateur est connecté
     * 
     * @return bool
     */
    public static function isLoggedIn(): bool
    {
        return auth()->check();
    }

    /**
     * Retourne l'utilisateur actuellement connecté
     * 
     * @return User|null
     */
    public static function getCurrentUser(): ?User
    {
        return auth()->user();
    }

    /**
     * Vérifie si un utilisateur a le droit d'accéder à une ressource
     * 
     * @param User $user Utilisateur
     * @param mixed $resource Ressource à vérifier
     * @return bool
     */
    public static function canAccess(User $user, $resource): bool
    {
        // Administrateurs ont accès à tout
        if (self::isAdmin($user)) {
            return true;
        }

        // Vérifier si la ressource appartient à l'utilisateur
        if (method_exists($resource, 'user_id') && $resource->user_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Vérifie si un utilisateur est organisateur d'un événement
     * 
     * @param User $user Utilisateur
     * @param \App\Models\Event $event Événement
     * @return bool
     */
    public static function isEventOrganizer(User $user, \App\Models\Event $event): bool
    {
        return $event->user_id === $user->id;
    }

    /**
     * Vérifie si un utilisateur participe à un événement
     * 
     * @param User $user Utilisateur
     * @param \App\Models\Event $event Événement
     * @return bool
     */
    public static function isEventParticipant(User $user, \App\Models\Event $event): bool
    {
        return $event->participants()->where('user_id', $user->id)->exists();
    }

    /**
     * Calcule la distance entre deux utilisateurs
     * 
     * @param User $user1 Premier utilisateur
     * @param User $user2 Deuxième utilisateur
     * @return float|null Distance en kilomètres ou null si les coordonnées ne sont pas disponibles
     */
    public static function distanceBetweenUsers(User $user1, User $user2): ?float
    {
        if (!$user1->latitude || !$user1->longitude || !$user2->latitude || !$user2->longitude) {
            return null;
        }

        return self::haversineDistance(
            $user1->latitude, $user1->longitude,
            $user2->latitude, $user2->longitude
        );
    }

    /**
     * Calcule la distance entre deux points géographiques en kilomètres
     * 
     * @param float $lat1 Latitude du premier point
     * @param float $lon1 Longitude du premier point
     * @param float $lat2 Latitude du deuxième point
     * @param float $lon2 Longitude du deuxième point
     * @return float Distance en kilomètres
     */
    public static function haversineDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371; // Rayon de la Terre en kilomètres

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $earthRadius * $c;

        return $distance;
    }

    /**
     * Convertit une adresse en coordonnées géographiques (latitude, longitude)
     * 
     * @param string $address Adresse à géocoder
     * @return array|null Tableau contenant la latitude et la longitude ou null en cas d'échec
     */
    public static function geocodeAddress(string $address): ?array
    {
        // Utilisation de l'API Nominatim (OpenStreetMap)
        $url = 'https://nominatim.openstreetmap.org/search';
        
        try {
            $response = Http::get($url, [
                'q' => $address,
                'format' => 'json',
                'limit' => 1,
            ]);
            
            if ($response->successful() && count($response->json()) > 0) {
                $data = $response->json()[0];
                return [
                    'latitude' => (float) $data['lat'],
                    'longitude' => (float) $data['lon'],
                ];
            }
        } catch (\Exception $e) {
            // Gérer l'erreur
            return null;
        }
        
        return null;
    }

    /**
     * Formate les informations de localisation d'un utilisateur
     * 
     * @param User $user Utilisateur
     * @return string Adresse formatée
     */
    public static function formatLocation(User $user): string
    {
        $parts = [];
        
        if ($user->city) {
            $parts[] = $user->city;
        }
        
        if ($user->state) {
            $parts[] = $user->state;
        }
        
        if ($user->country) {
            $parts[] = $user->country;
        }
        
        return implode(', ', $parts);
    }

    /**
     * Met à jour ou crée un utilisateur avec les données fournies
     * 
     * @param array $data Données de l'utilisateur
     * @param User|null $user Utilisateur existant (null pour créer un nouvel utilisateur)
     * @return User
     */
    public static function updateOrCreateUser(array $data, ?User $user = null): User
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];

        // Ajouter le mot de passe seulement lors de la création ou si un nouveau mot de passe est fourni
        if (!$user || (isset($data['password']) && !empty($data['password']))) {
            $userData['password'] = Hash::make($data['password']);
        }

        // Ajouter les informations de localisation si elles sont fournies
        foreach (['address', 'city', 'state', 'postal_code', 'country', 'latitude', 'longitude', 'phone', 'bio'] as $field) {
            if (isset($data[$field])) {
                $userData[$field] = $data[$field];
            }
        }

        // Géocoder l'adresse si les coordonnées ne sont pas fournies mais que l'adresse l'est
        if (!isset($userData['latitude']) && !isset($userData['longitude']) && 
            isset($userData['address']) && isset($userData['city'])) {
            $address = implode(', ', array_filter([
                $userData['address'] ?? null,
                $userData['city'] ?? null,
                $userData['state'] ?? null,
                $userData['postal_code'] ?? null,
                $userData['country'] ?? null,
            ]));
            
            $coords = self::geocodeAddress($address);
            if ($coords) {
                $userData['latitude'] = $coords['latitude'];
                $userData['longitude'] = $coords['longitude'];
            }
        }

        // Mettre à jour ou créer l'utilisateur
        if ($user) {
            $user->update($userData);
        } else {
            $user = User::create($userData);
        }

        return $user;
    }
}