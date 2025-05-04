<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
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
        'type',
        'amount',
        'quantity',
        'condition',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'total_amount' => 'decimal:2',
        'completion_date' => 'datetime',
    ];

    /**
     * Get the user that owns the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the card that was transacted.
     */
    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    /**
     * Get the seller associated with the transaction.
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * Get the buyer associated with the transaction.
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    /**
     * The cards that belong to the transaction.
     * This is a many-to-many relationship through a pivot table with additional attributes.
     */
    public function cards()
    {
        return $this->belongsToMany(Collection::class, 'transaction_items')
                    ->withPivot('quantity', 'price_per_card')
                    ->withTimestamps();
    }
}
