<?php

namespace App\Helpers;

use App\Models\Collection;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Str;

class TransactionHelper
{
    /**
     * Crée une nouvelle transaction (vente ou échange)
     * 
     * @param User $seller Vendeur/expéditeur
     * @param User $buyer Acheteur/destinataire
     * @param string $type Type de transaction (sale, trade, auction)
     * @param array $items Éléments échangés (collections.id => quantity)
     * @param float|null $amount Montant de la transaction (pour les ventes)
     * @return Transaction Transaction créée
     */
    public static function createTransaction(User $seller, User $buyer, string $type, array $items, ?float $amount = null): Transaction
    {
        // Créer une référence unique pour la transaction
        $reference = self::generateTransactionReference();
        
        // Préparer les éléments échangés sous forme de JSON
        $itemsExchanged = [];
        $sellerItems = [];
        $buyerItems = [];
        
        // Traiter les éléments du vendeur
        if (isset($items['seller']) && is_array($items['seller'])) {
            foreach ($items['seller'] as $collectionId => $quantity) {
                $collection = Collection::findOrFail($collectionId);
                
                // Vérifier que la collection appartient bien au vendeur
                if ($collection->user_id !== $seller->id) {
                    throw new \Exception("La collection #{$collectionId} n'appartient pas au vendeur.");
                }
                
                // Vérifier que la quantité est disponible
                if ($collection->quantity < $quantity) {
                    throw new \Exception("Quantité insuffisante pour la carte {$collection->card->name}.");
                }
                
                $sellerItems[] = [
                    'collection_id' => $collection->id,
                    'card_id' => $collection->card_id,
                    'card_name' => $collection->card->name,
                    'condition' => $collection->condition,
                    'quantity' => $quantity,
                ];
            }
        }
        
        // Traiter les éléments de l'acheteur (pour les échanges)
        if ($type === 'trade' && isset($items['buyer']) && is_array($items['buyer'])) {
            foreach ($items['buyer'] as $collectionId => $quantity) {
                $collection = Collection::findOrFail($collectionId);
                
                // Vérifier que la collection appartient bien à l'acheteur
                if ($collection->user_id !== $buyer->id) {
                    throw new \Exception("La collection #{$collectionId} n'appartient pas à l'acheteur.");
                }
                
                // Vérifier que la quantité est disponible
                if ($collection->quantity < $quantity) {
                    throw new \Exception("Quantité insuffisante pour la carte {$collection->card->name}.");
                }
                
                $buyerItems[] = [
                    'collection_id' => $collection->id,
                    'card_id' => $collection->card_id,
                    'card_name' => $collection->card->name,
                    'condition' => $collection->condition,
                    'quantity' => $quantity,
                ];
            }
        }
        
        $itemsExchanged = [
            'seller' => $sellerItems,
            'buyer' => $buyerItems,
        ];
        
        // Créer la transaction
        $transaction = Transaction::create([
            'seller_id' => $seller->id,
            'buyer_id' => $buyer->id,
            'type' => $type,
            'total_amount' => $amount,
            'status' => 'pending',
            'transaction_date' => Carbon::now(),
            'transaction_reference' => $reference,
            'items_exchanged' => json_encode($itemsExchanged),
        ]);
        
        return $transaction;
    }

    /**
     * Génère une référence unique pour une transaction
     * 
     * @return string Référence unique
     */
    private static function generateTransactionReference(): string
    {
        $prefix = 'TX';
        $timestamp = Carbon::now()->format('YmdHis');
        $random = strtoupper(Str::random(4));
        
        return "{$prefix}-{$timestamp}-{$random}";
    }

    /**
     * Finalise une transaction en mettant à jour les collections
     * 
     * @param Transaction $transaction Transaction à finaliser
     * @return bool Succès de l'opération
     */
    public static function finalizeTransaction(Transaction $transaction): bool
    {
        // Vérifier que la transaction est en attente
        if ($transaction->status !== 'pending') {
            return false;
        }
        
        // Récupérer les éléments échangés
        $itemsExchanged = json_decode($transaction->items_exchanged, true);
        
        // Traiter les éléments du vendeur
        if (isset($itemsExchanged['seller'])) {
            foreach ($itemsExchanged['seller'] as $item) {
                $collection = Collection::find($item['collection_id']);
                
                if ($collection) {
                    // Réduire la quantité
                    $collection->quantity -= $item['quantity'];
                    
                    // Si la quantité devient nulle, supprimer l'entrée
                    if ($collection->quantity <= 0) {
                        $collection->delete();
                    } else {
                        $collection->save();
                    }
                    
                    // Ajouter à la collection de l'acheteur
                    CardHelper::addOrUpdateCollectionCard(
                        User::find($transaction->buyer_id),
                        $item['card_id'],
                        [
                            'quantity' => $item['quantity'],
                            'condition' => $item['condition'],
                        ]
                    );
                }
            }
        }
        
        // Traiter les éléments de l'acheteur (pour les échanges)
        if ($transaction->type === 'trade' && isset($itemsExchanged['buyer'])) {
            foreach ($itemsExchanged['buyer'] as $item) {
                $collection = Collection::find($item['collection_id']);
                
                if ($collection) {
                    // Réduire la quantité
                    $collection->quantity -= $item['quantity'];
                    
                    // Si la quantité devient nulle, supprimer l'entrée
                    if ($collection->quantity <= 0) {
                        $collection->delete();
                    } else {
                        $collection->save();
                    }
                    
                    // Ajouter à la collection du vendeur
                    CardHelper::addOrUpdateCollectionCard(
                        User::find($transaction->seller_id),
                        $item['card_id'],
                        [
                            'quantity' => $item['quantity'],
                            'condition' => $item['condition'],
                        ]
                    );
                }
            }
        }
        
        // Mettre à jour le statut de la transaction
        $transaction->status = 'completed';
        $transaction->save();
        
        return true;
    }

    /**
     * Annule une transaction
     * 
     * @param Transaction $transaction Transaction à annuler
     * @param string|null $reason Raison de l'annulation
     * @return bool Succès de l'opération
     */
    public static function cancelTransaction(Transaction $transaction, ?string $reason = null): bool
    {
        // Vérifier que la transaction est en attente
        if ($transaction->status !== 'pending') {
            return false;
        }
        
        // Mettre à jour le statut de la transaction
        $transaction->status = 'cancelled';
        $transaction->notes = $reason;
        $transaction->save();
        
        return true;
    }

    /**
     * Récupère les transactions d'un utilisateur (ventes et achats)
     * 
     * @param User $user Utilisateur
     * @param string|null $type Type de transaction (seller, buyer, both)
     * @param int $limit Nombre maximum de transactions à récupérer
     * @return SupportCollection Collection de transactions
     */
    public static function getUserTransactions(User $user, ?string $type = 'both', int $limit = 20): SupportCollection
    {
        if ($type === 'seller') {
            return Transaction::with(['buyer'])
                ->where('seller_id', $user->id)
                ->orderByDesc('transaction_date')
                ->limit($limit)
                ->get();
        } elseif ($type === 'buyer') {
            return Transaction::with(['seller'])
                ->where('buyer_id', $user->id)
                ->orderByDesc('transaction_date')
                ->limit($limit)
                ->get();
        } else {
            return Transaction::with(['seller', 'buyer'])
                ->where(function ($query) use ($user) {
                    $query->where('seller_id', $user->id)
                          ->orWhere('buyer_id', $user->id);
                })
                ->orderByDesc('transaction_date')
                ->limit($limit)
                ->get();
        }
    }

    /**
     * Calcule le total des ventes d'un utilisateur
     * 
     * @param User $user Utilisateur
     * @param string|null $period Période (all, month, year)
     * @return float Total des ventes
     */
    public static function getUserSalesTotal(User $user, ?string $period = 'all'): float
    {
        $query = Transaction::where('seller_id', $user->id)
            ->where('status', 'completed')
            ->where('type', 'sale');
            
        // Filtre par période
        if ($period === 'month') {
            $query->whereMonth('transaction_date', Carbon::now()->month)
                  ->whereYear('transaction_date', Carbon::now()->year);
        } elseif ($period === 'year') {
            $query->whereYear('transaction_date', Carbon::now()->year);
        }
        
        return $query->sum('total_amount') ?? 0;
    }

    /**
     * Formate un montant en devise
     * 
     * @param float|null $amount Montant
     * @param string $currency Devise
     * @return string Montant formaté
     */
    public static function formatAmount(?float $amount, string $currency = 'EUR'): string
    {
        if ($amount === null) {
            return 'N/A';
        }
        
        switch ($currency) {
            case 'EUR':
                return number_format($amount, 2, ',', ' ') . ' €';
                
            case 'USD':
                return '$' . number_format($amount, 2, '.', ',');
                
            default:
                return number_format($amount, 2) . ' ' . $currency;
        }
    }

    /**
     * Récupère les éléments d'une transaction sous forme lisible
     * 
     * @param Transaction $transaction Transaction
     * @return array Données des éléments échangés
     */
    public static function getTransactionItems(Transaction $transaction): array
    {
        $itemsExchanged = json_decode($transaction->items_exchanged, true);
        
        $sellerItems = $itemsExchanged['seller'] ?? [];
        $buyerItems = $itemsExchanged['buyer'] ?? [];
        
        // Formater les éléments pour un affichage plus lisible
        $formattedSellerItems = [];
        foreach ($sellerItems as $item) {
            $formattedSellerItems[] = [
                'name' => $item['card_name'],
                'condition' => CardHelper::formatCondition($item['condition']),
                'quantity' => $item['quantity'],
            ];
        }
        
        $formattedBuyerItems = [];
        foreach ($buyerItems as $item) {
            $formattedBuyerItems[] = [
                'name' => $item['card_name'],
                'condition' => CardHelper::formatCondition($item['condition']),
                'quantity' => $item['quantity'],
            ];
        }
        
        return [
            'seller' => $formattedSellerItems,
            'buyer' => $formattedBuyerItems,
        ];
    }
}