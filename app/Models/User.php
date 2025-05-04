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
    public function isAdmin()
    {
        return $this->is_admin ?? false;
    }
}
