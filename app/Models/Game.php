<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'publisher',
        'description',
        'logo_url',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the cards for the game.
     */
    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    /**
     * Get the events for the game.
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}