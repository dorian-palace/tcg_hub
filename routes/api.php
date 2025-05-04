<?php

use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\CollectionController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\EventSearchController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\ParticipationController;
use App\Http\Controllers\Api\TransactionController;
use App\Facades\UserHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Games
Route::get('/games', [GameController::class, 'index']);
Route::get('/games/{game}', [GameController::class, 'show']);

// Cards
Route::get('/cards', [CardController::class, 'index']);
Route::get('/cards/{card}', [CardController::class, 'show']);

// Events - public searches
Route::get('/events/search', [EventSearchController::class, 'search']);
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{event}', [EventController::class, 'show']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Games
    Route::post('/games', [GameController::class, 'store']);
    Route::put('/games/{game}', [GameController::class, 'update']);
    Route::delete('/games/{game}', [GameController::class, 'destroy']);
    
    // Cards
    Route::post('/cards', [CardController::class, 'store']);
    Route::put('/cards/{card}', [CardController::class, 'update']);
    Route::delete('/cards/{card}', [CardController::class, 'destroy']);
    
    // Events
    Route::post('/events', [EventController::class, 'store']);
    Route::put('/events/{event}', [EventController::class, 'update']);
    Route::delete('/events/{event}', [EventController::class, 'destroy']);
    
    // Participations
    Route::get('/participations', [ParticipationController::class, 'index']);
    Route::post('/participations', [ParticipationController::class, 'store']);
    Route::get('/participations/{participation}', [ParticipationController::class, 'show']);
    Route::put('/participations/{participation}', [ParticipationController::class, 'update']);
    Route::delete('/participations/{participation}', [ParticipationController::class, 'destroy']);
    
    // Collections
    Route::get('/collections', [CollectionController::class, 'index']);
    Route::post('/collections', [CollectionController::class, 'store']);
    Route::get('/collections/{collection}', [CollectionController::class, 'show']);
    Route::put('/collections/{collection}', [CollectionController::class, 'update']);
    Route::delete('/collections/{collection}', [CollectionController::class, 'destroy']);
    
    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show']);
    Route::put('/transactions/{transaction}', [TransactionController::class, 'update']);
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy']);
    
    // User profile
    Route::get('/profile', function (Request $request) {
        return $request->user()->load('events', 'participations.event');
    });
    
    Route::put('/profile', function (Request $request) {
        $user = $request->user();
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'address' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:100',
            'postal_code' => 'sometimes|string|max:20',
            'latitude' => 'sometimes|numeric|between:-90,90',
            'longitude' => 'sometimes|numeric|between:-180,180',
        ]);
        
        // Update user with our UserHelper facade
        $updatedUser = UserHelper::updateUserProfile($user, $validated);
        
        return response()->json($updatedUser);
    });
});