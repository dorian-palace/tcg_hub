<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Forum extends Model
{
    use HasFactory;

    const CATEGORIES = [
        'general' => 'Général',
        'tournois' => 'Tournois',
        'echange' => 'Échange',
        'strategie' => 'Stratégie',
        'evenements' => 'Événements'
    ];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'game_id',
        'is_active',
        'order',
        'category'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function topics()
    {
        return $this->hasMany(ForumTopic::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
