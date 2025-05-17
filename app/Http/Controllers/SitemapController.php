<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Game;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $content = view('sitemap.index', [
            'events' => Event::where('start_datetime', '>', now())->get(),
            'games' => Game::where('is_active', true)->get(),
        ])->render();

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
} 