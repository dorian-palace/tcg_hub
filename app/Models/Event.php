<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'game_id',
        'title',
        'description',
        'venue_name',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'latitude',
        'longitude',
        'start_datetime',
        'end_datetime',
        'event_type',
        'max_participants',
        'entry_fee',
        'prizes',
        'is_approved',
        'is_cancelled',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'entry_fee' => 'decimal:2',
        'is_approved' => 'boolean',
        'is_cancelled' => 'boolean',
    ];

    /**
     * Get the user (organizer) that owns the event.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the game associated with the event.
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Get the participations for the event.
     */
    public function participations()
    {
        return $this->hasMany(Participation::class);
    }

    /**
     * Get the participants (users) of the event.
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'participations')
                    ->withPivot('status', 'registration_date', 'payment_received', 'notes', 'final_ranking')
                    ->withTimestamps();
    }
}