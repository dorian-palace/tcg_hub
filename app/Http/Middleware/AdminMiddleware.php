<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        // Debug information
        if ($user) {
            Log::info('User ID: ' . $user->id);
            Log::info('Is Admin: ' . ($user->is_admin ? 'true' : 'false'));
            Log::info('Is Admin Method: ' . ($user->isAdmin() ? 'true' : 'false'));
            Log::info('User Data: ' . json_encode($user->toArray()));
        } else {
            Log::info('No user found');
        }

        if (!$user || !$user->isAdmin()) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}