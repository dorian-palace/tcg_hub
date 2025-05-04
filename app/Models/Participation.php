<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'event_id',
        'status',  // 'registered', 'confirmed', 'cancelled', 'attended'
        'registration_date',
        'payment_received',
        'notes',
        'final_ranking',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'registration_date' => 'datetime',
        'payment_received' => 'boolean',
    ];

    /**
     * Get the user that owns the participation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the event that the participation belongs to.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
