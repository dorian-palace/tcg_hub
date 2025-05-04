<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'card_id',
        'quantity',
        'condition', // 'mint', 'near_mint', 'excellent', 'good', 'played', 'poor'
        'for_sale',
        'for_trade',
        'price',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'quantity' => 'integer',
        'for_sale' => 'boolean',
        'for_trade' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * Get the user that owns the collection item.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the card associated with the collection item.
     */
    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    /**
     * Get the transactions that this collection item is part of.
     */
    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'transaction_items')
                    ->withPivot('quantity', 'price_per_card')
                    ->withTimestamps();
    }
}
