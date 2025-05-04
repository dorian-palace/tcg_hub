<?php

namespace App\Helpers;

use App\Models\Card;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection as SupportCollection;

class CardHelper
{
    /**
     * Récupère les cartes les plus populaires (les plus présentes dans les collections)
     * 
     * @param int $limit Nombre maximum de cartes à récupérer
     * @return SupportCollection Collection de cartes
     */
    public static function getPopularCards(int $limit = 10): SupportCollection
    {
        return Card::withCount('collections')
            ->orderByDesc('collections_count')
            ->limit($limit)
            ->get();
    }

    /**
     * Récupère les cartes d'un jeu spécifique
     * 
     * @param int $gameId ID du jeu
     * @param array $filters Filtres supplémentaires
     * @return Builder Builder de la requête
     */
    public static function getCardsByGame(int $gameId, array $filters = []): Builder
    {
        $query = Card::where('game_id', $gameId);
        
        // Filtre par set
        if (isset($filters['set_name']) && $filters['set_name']) {
            $query->where('set_name', $filters['set_name']);
        }
        
        // Filtre par rareté
        if (isset($filters['rarity']) && $filters['rarity']) {
            $query->where('rarity', $filters['rarity']);
        }
        
        // Filtre par recherche de nom
        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Tri
        $sortBy = $filters['sort'] ?? 'name';
        $sortDir = $filters['sort_dir'] ?? 'asc';
        
        switch ($sortBy) {
            case 'price':
                $query->orderBy('avg_market_price', $sortDir);
                break;
                
            case 'rarity':
                $query->orderBy('rarity', $sortDir);
                break;
                
            case 'set':
                $query->orderBy('set_name', $sortDir)
                      ->orderBy('card_number', $sortDir);
                break;
                
            case 'name':
            default:
                $query->orderBy('name', $sortDir);
                break;
        }
        
        return $query;
    }

    /**
     * Récupère les sets disponibles pour un jeu
     * 
     * @param int $gameId ID du jeu
     * @return array Liste des sets
     */
    public static function getSetsByGame(int $gameId): array
    {
        return Card::where('game_id', $gameId)
            ->select('set_name')
            ->distinct()
            ->orderBy('set_name')
            ->pluck('set_name')
            ->toArray();
    }

    /**
     * Récupère les raretés disponibles pour un jeu
     * 
     * @param int $gameId ID du jeu
     * @return array Liste des raretés
     */
    public static function getRaritiesByGame(int $gameId): array
    {
        return Card::where('game_id', $gameId)
            ->select('rarity')
            ->distinct()
            ->orderBy('rarity')
            ->pluck('rarity')
            ->toArray();
    }

    /**
     * Formate les conditions de carte pour affichage
     * 
     * @param string $condition Code de la condition
     * @return string Libellé de la condition
     */
    public static function formatCondition(string $condition): string
    {
        $conditions = [
            'mint' => 'Mint (Parfait état)',
            'near_mint' => 'Near Mint (Très bon état)',
            'excellent' => 'Excellent',
            'good' => 'Bon état',
            'played' => 'Joué',
            'poor' => 'Abîmé',
        ];
        
        return $conditions[$condition] ?? $condition;
    }

    /**
     * Récupère l'URL d'image pour une carte
     * 
     * @param Card $card Carte
     * @return string URL de l'image
     */
    public static function getCardImageUrl(Card $card): string
    {
        // Si la carte a une image spécifiée
        if ($card->image_url) {
            return $card->image_url;
        }
        
        // Image par défaut selon le jeu
        switch ($card->game_id) {
            case 1: // Pokémon
                return asset('images/cards/default_pokemon.jpg');
                
            case 2: // Magic
                return asset('images/cards/default_magic.jpg');
                
            case 3: // Yu-Gi-Oh
                return asset('images/cards/default_yugioh.jpg');
                
            default:
                return asset('images/cards/default_card.jpg');
        }
    }

    /**
     * Vérifie la disponibilité d'une carte dans la collection d'un utilisateur
     * 
     * @param User $user Utilisateur
     * @param Card $card Carte
     * @return array Données de disponibilité (quantité, pour vente, pour échange)
     */
    public static function checkCardAvailability(User $user, Card $card): array
    {
        $collections = Collection::where('user_id', $user->id)
            ->where('card_id', $card->id)
            ->get();
            
        $total = 0;
        $forSale = 0;
        $forTrade = 0;
        
        foreach ($collections as $collection) {
            $total += $collection->quantity;
            
            if ($collection->for_sale) {
                $forSale += $collection->quantity;
            }
            
            if ($collection->for_trade) {
                $forTrade += $collection->quantity;
            }
        }
        
        return [
            'total' => $total,
            'for_sale' => $forSale,
            'for_trade' => $forTrade,
        ];
    }

    /**
     * Récupère les cartes d'une collection utilisateur
     * 
     * @param User $user Utilisateur
     * @param array $filters Filtres supplémentaires
     * @return Builder Builder de la requête
     */
    public static function getUserCollection(User $user, array $filters = []): Builder
    {
        $query = Collection::with(['card', 'card.game'])
            ->where('user_id', $user->id);
        
        // Filtre par jeu
        if (isset($filters['game_id']) && $filters['game_id']) {
            $query->whereHas('card', function ($q) use ($filters) {
                $q->where('game_id', $filters['game_id']);
            });
        }
        
        // Filtre par set
        if (isset($filters['set_name']) && $filters['set_name']) {
            $query->whereHas('card', function ($q) use ($filters) {
                $q->where('set_name', $filters['set_name']);
            });
        }
        
        // Filtre par condition
        if (isset($filters['condition']) && $filters['condition']) {
            $query->where('condition', $filters['condition']);
        }
        
        // Filtre par disponibilité
        if (isset($filters['availability'])) {
            if ($filters['availability'] === 'for_sale') {
                $query->where('for_sale', true);
            } elseif ($filters['availability'] === 'for_trade') {
                $query->where('for_trade', true);
            }
        }
        
        // Filtre par recherche
        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->whereHas('card', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }
        
        // Tri
        $sortBy = $filters['sort'] ?? 'name';
        
        switch ($sortBy) {
            case 'price':
                $query->orderBy('price', 'desc');
                break;
                
            case 'condition':
                $query->orderBy('condition');
                break;
                
            case 'quantity':
                $query->orderBy('quantity', 'desc');
                break;
                
            case 'name':
            default:
                $query->join('cards', 'collections.card_id', '=', 'cards.id')
                      ->orderBy('cards.name');
                break;
        }
        
        return $query;
    }

    /**
     * Ajoute ou met à jour une carte dans la collection d'un utilisateur
     * 
     * @param User $user Utilisateur
     * @param int $cardId ID de la carte
     * @param array $data Données de la carte dans la collection
     * @return Collection Entrée de collection créée ou mise à jour
     */
    public static function addOrUpdateCollectionCard(User $user, int $cardId, array $data): Collection
    {
        // Vérifier si la carte existe déjà dans la collection avec la même condition
        $existingCard = Collection::where('user_id', $user->id)
            ->where('card_id', $cardId)
            ->where('condition', $data['condition'] ?? 'near_mint')
            ->first();
            
        if ($existingCard) {
            // Mettre à jour la quantité et les autres données
            $existingCard->quantity = ($data['quantity'] ?? 1) + $existingCard->quantity;
            $existingCard->for_trade = $data['for_trade'] ?? $existingCard->for_trade;
            $existingCard->for_sale = $data['for_sale'] ?? $existingCard->for_sale;
            $existingCard->price = $data['price'] ?? $existingCard->price;
            $existingCard->notes = $data['notes'] ?? $existingCard->notes;
            $existingCard->save();
            
            return $existingCard;
        }
        
        // Créer une nouvelle entrée dans la collection
        return Collection::create([
            'user_id' => $user->id,
            'card_id' => $cardId,
            'quantity' => $data['quantity'] ?? 1,
            'condition' => $data['condition'] ?? 'near_mint',
            'for_trade' => $data['for_trade'] ?? false,
            'for_sale' => $data['for_sale'] ?? false,
            'price' => $data['price'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);
    }
}