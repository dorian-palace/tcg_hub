<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\Game;
use App\Models\Collection;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques générales
        $stats = [
            'users' => [
                'total' => User::count(),
                'new_this_month' => User::whereMonth('created_at', now()->month)->count(),
                'active' => DB::table('sessions')
                    ->where('last_activity', '>=', now()->subDays(30)->timestamp)
                    ->distinct('user_id')
                    ->count('user_id'),
            ],
            'events' => [
                'total' => Event::count(),
                'upcoming' => Event::upcoming()->count(),
                'ongoing' => Event::ongoing()->count(),
                'pending_approval' => Event::where('is_approved', false)->count(),
            ],
            'games' => [
                'total' => Game::count(),
                'active' => Game::where('is_active', true)->count(),
            ],
            'transactions' => [
                'total' => Transaction::count(),
                'this_month' => Transaction::whereMonth('created_at', now()->month)->count(),
            ],
        ];

        // Top 5 des jeux les plus populaires
        $popularGames = Game::withCount('events')
            ->orderBy('events_count', 'desc')
            ->take(5)
            ->get();

        // Top 5 des organisateurs d'événements
        $topOrganizers = User::withCount('organizedEvents')
            ->orderBy('organized_events_count', 'desc')
            ->take(5)
            ->get();

        // Dernières transactions
        $recentTransactions = Transaction::with(['seller', 'buyer', 'cards'])
            ->latest()
            ->take(5)
            ->get();

        // Événements à venir
        $upcomingEvents = Event::with(['user', 'game'])
            ->upcoming()
            ->take(5)
            ->get();

        // Statistiques des utilisateurs par pays
        $usersByCountry = User::select('country', DB::raw('count(*) as total'))
            ->groupBy('country')
            ->orderBy('total', 'desc')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'popularGames',
            'topOrganizers',
            'recentTransactions',
            'upcomingEvents',
            'usersByCountry'
        ));
    }
} 