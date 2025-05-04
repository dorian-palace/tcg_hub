<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'latitude',
        'longitude',
        'phone',
        'bio',
        'avatar',
        'preferences',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'latitude' => 'float',
            'longitude' => 'float',
            'preferences' => 'json',
            'is_admin' => 'boolean',
        ];
    }
    
    /**
     * Get the collections for the user.
     */
    public function collections()
    {
        return $this->hasMany(Collection::class);
    }
    
    /**
     * Get the events organized by the user.
     */
    public function organizedEvents()
    {
        return $this->hasMany(Event::class);
    }
    
    /**
     * Get the events that the user is participating in.
     */
    public function participatingEvents()
    {
        return $this->belongsToMany(Event::class, 'participations')
                    ->withPivot('status', 'registration_date', 'payment_received', 'notes', 'final_ranking')
                    ->withTimestamps();
    }
    
    /**
     * Get the participations for the user.
     */
    public function participations()
    {
        return $this->hasMany(Participation::class);
    }
    
    /**
     * Get the sales (as seller) for the user.
     */
    public function sales()
    {
        return $this->hasMany(Transaction::class, 'seller_id');
    }
    
    /**
     * Get the purchases (as buyer) for the user.
     */
    public function purchases()
    {
        return $this->hasMany(Transaction::class, 'buyer_id');
    }
    
    /**
     * Check if the user is an admin.
     * 
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOrganizer(): bool
    {
        return $this->role === 'organizer';
    }

    public function isPlayer(): bool
    {
        return $this->role === 'player';
    }

    public function getUpcomingEvents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->events()
            ->where('start_datetime', '>', now())
            ->where('is_cancelled', false)
            ->orderBy('start_datetime');
    }

    public function getPastEvents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->events()
            ->where('end_datetime', '<', now())
            ->orderBy('end_datetime', 'desc');
    }

    public function getOngoingEvents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->events()
            ->where('start_datetime', '<=', now())
            ->where('end_datetime', '>=', now())
            ->where('is_cancelled', false);
    }

    public function getParticipatingEvents(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->participatingEvents()
            ->where('is_cancelled', false)
            ->orderBy('start_datetime');
    }

    public function getUpcomingParticipations(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->getParticipatingEvents()
            ->where('start_datetime', '>', now());
    }

    public function getPastParticipations(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->getParticipatingEvents()
            ->where('end_datetime', '<', now());
    }

    public function getOngoingParticipations(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->getParticipatingEvents()
            ->where('start_datetime', '<=', now())
            ->where('end_datetime', '>=', now());
    }

    public function getFormattedName(): string
    {
        return $this->name;
    }

    public function getFormattedRole(): string
    {
        return match($this->role) {
            'admin' => 'Administrateur',
            'organizer' => 'Organisateur',
            'player' => 'Joueur',
            default => $this->role
        };
    }

    public function getEventCount(): int
    {
        return $this->events()->count();
    }

    public function getParticipationCount(): int
    {
        return $this->participatingEvents()->count();
    }

    public function getUpcomingEventCount(): int
    {
        return $this->getUpcomingEvents()->count();
    }

    public function getPastEventCount(): int
    {
        return $this->getPastEvents()->count();
    }

    public function getOngoingEventCount(): int
    {
        return $this->getOngoingEvents()->count();
    }

    public function getUpcomingParticipationCount(): int
    {
        return $this->getUpcomingParticipations()->count();
    }

    public function getPastParticipationCount(): int
    {
        return $this->getPastParticipations()->count();
    }

    public function getOngoingParticipationCount(): int
    {
        return $this->getOngoingParticipations()->count();
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeOrganizers($query)
    {
        return $query->where('role', 'organizer');
    }

    public function scopePlayers($query)
    {
        return $query->where('role', 'player');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeWithEvents($query)
    {
        return $query->has('events');
    }

    public function scopeWithParticipations($query)
    {
        return $query->has('participatingEvents');
    }
}
