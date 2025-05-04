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

    public function isUpcoming(): bool
    {
        return $this->start_datetime > now();
    }

    public function isPast(): bool
    {
        return $this->end_datetime < now();
    }

    public function isOngoing(): bool
    {
        return now()->between($this->start_datetime, $this->end_datetime);
    }

    public function isFull(): bool
    {
        return $this->participants()->count() >= $this->max_participants;
    }

    public function hasParticipant(User $user): bool
    {
        return $this->participants()->where('user_id', $user->id)->exists();
    }

    public function getRemainingSpots(): int
    {
        return max(0, $this->max_participants - $this->participants()->count());
    }

    public function getDurationInHours(): float
    {
        return $this->start_datetime->diffInHours($this->end_datetime);
    }

    public function getFormattedDate(): string
    {
        return $this->start_datetime->format('d/m/Y H:i');
    }

    public function getFormattedDuration(): string
    {
        $hours = $this->getDurationInHours();
        return $hours . ' heure' . ($hours > 1 ? 's' : '');
    }

    public function getFormattedLocation(): string
    {
        $location = $this->venue_name;
        if ($this->address) {
            $location .= ', ' . $this->address;
        }
        if ($this->city) {
            $location .= ', ' . $this->city;
        }
        if ($this->postal_code) {
            $location .= ' ' . $this->postal_code;
        }
        return $location;
    }

    public function getFormattedEntryFee(): string
    {
        return $this->entry_fee ? number_format($this->entry_fee, 2) . '€' : 'Gratuit';
    }

    public function getFormattedEventType(): string
    {
        return match($this->event_type) {
            'tournament' => 'Tournoi',
            'casual_play' => 'Partie libre',
            'trade' => 'Échange',
            'release' => 'Pré-release',
            'other' => 'Autre',
            default => $this->event_type
        };
    }

    public function getStatus(): string
    {
        if ($this->is_cancelled) {
            return 'Annulé';
        }
        if ($this->isPast()) {
            return 'Terminé';
        }
        if ($this->isOngoing()) {
            return 'En cours';
        }
        if ($this->isUpcoming()) {
            return 'À venir';
        }
        return 'Statut inconnu';
    }

    public function getStatusColor(): string
    {
        return match($this->getStatus()) {
            'Annulé' => 'red',
            'Terminé' => 'gray',
            'En cours' => 'green',
            'À venir' => 'blue',
            default => 'gray'
        };
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_datetime', '>', now())
            ->where('is_cancelled', false)
            ->orderBy('start_datetime');
    }

    public function scopePast($query)
    {
        return $query->where('end_datetime', '<', now())
            ->orderBy('end_datetime', 'desc');
    }

    public function scopeOngoing($query)
    {
        return $query->where('start_datetime', '<=', now())
            ->where('end_datetime', '>=', now())
            ->where('is_cancelled', false);
    }

    public function scopeByGame($query, $gameId)
    {
        return $query->where('game_id', $gameId);
    }

    public function scopeByCity($query, $city)
    {
        return $query->where('city', 'like', '%' . $city . '%');
    }

    public function scopeByEventType($query, $eventType)
    {
        return $query->where('event_type', $eventType);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeNotCancelled($query)
    {
        return $query->where('is_cancelled', false);
    }
}