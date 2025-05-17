<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ForumTopicController;
use App\Http\Controllers\ForumPostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Page de test des routes
Route::get('/test', function () {
    return view('test');
});

// Routes for SPA frontend (Vue.js)
Route::get('/events/find', [\App\Http\Controllers\EventController::class, 'find'])->name('events.find');

// Routes for game catalog
Route::get('/games', [\App\Http\Controllers\GameController::class, 'index'])->name('games.index');
Route::get('/games/{game}', [\App\Http\Controllers\GameController::class, 'show'])->name('games.show');

// Routes for card catalog
Route::get('/cards', [\App\Http\Controllers\CardController::class, 'index'])->name('cards.index');

Route::get('/cards/{id}', function ($id) {
    return view('cards.show', compact('id'));
})->name('cards.show');

// Routes d'authentification
Route::get('/login', [\App\Http\Controllers\Auth\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');
Route::get('/register', [\App\Http\Controllers\Auth\AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [\App\Http\Controllers\Auth\AuthController::class, 'register']);

// Routes protégées nécessitant une authentification
Route::middleware(['auth'])->group(function () {
    // User profile routes
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    Route::get('/profile/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // Admin game management routes
    Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
        Route::get('/admin/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/games/create', [\App\Http\Controllers\GameController::class, 'create'])->name('games.create');
        Route::post('/admin/games', [\App\Http\Controllers\GameController::class, 'store'])->name('games.store');
        Route::get('/admin/games/{game}/edit', [\App\Http\Controllers\GameController::class, 'edit'])->name('games.edit');
        Route::put('/admin/games/{game}', [\App\Http\Controllers\GameController::class, 'update'])->name('games.update');
        Route::delete('/admin/games/{game}', [\App\Http\Controllers\GameController::class, 'destroy'])->name('games.destroy');
    });

    // Event management routes
    Route::get('/my-events', function () {
        return view('events.my-events');
    })->name('my-events');

    Route::get('/events/create', function () {
        return view('events.create');
    })->name('events.create');

    Route::get('/events/{id}/edit', function ($id) {
        $event = \App\Models\Event::findOrFail($id);
        $games = \App\Models\Game::all();
        return view('events.edit', compact('event', 'games'));
    })->name('events.edit');

    Route::get('/events/{id}/participants', function ($id) {
        return view('events.participants', compact('id'));
    })->name('events.participants');

    // Collection management routes
    Route::get('/my-collection', function () {
        return view('collection.index');
    })->name('my-collection');

    Route::get('/collection/add', function () {
        return view('collection.add');
    })->name('collection.add');

    // Transaction routes
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::patch('/transactions/{transaction}/complete', [TransactionController::class, 'complete'])->name('transactions.complete');
    Route::patch('/transactions/{transaction}/cancel', [TransactionController::class, 'cancel'])->name('transactions.cancel');

    // Routes for events
    Route::get('/events', [\App\Http\Controllers\EventController::class, 'index'])
        ->name('events.index');
    Route::get('/events/create', [\App\Http\Controllers\EventController::class, 'create'])
        ->name('events.create');
    Route::post('/events', [\App\Http\Controllers\EventController::class, 'store'])
        ->name('events.store');
    Route::get('/events/{id}', [\App\Http\Controllers\EventController::class, 'show'])
        ->name('events.show');
    Route::put('/events/{id}', [\App\Http\Controllers\EventController::class, 'update'])
        ->name('events.update');

    // Routes pour les commentaires
    Route::post('/events/{event}/comments', [\App\Http\Controllers\CommentController::class, 'store'])
        ->name('comments.store');
    Route::put('/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'update'])
        ->name('comments.update');
    Route::delete('/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'destroy'])
        ->name('comments.destroy');

    // Forum Routes
    Route::get('/forums', [ForumController::class, 'index'])->name('forums.index');
    Route::get('/forums/create', [ForumController::class, 'create'])->name('forums.create');
    Route::post('/forums', [ForumController::class, 'store'])->name('forums.store');
    Route::get('/forums/{forum}', [ForumController::class, 'show'])->name('forums.show');
    Route::get('/forums/{forum}/edit', [ForumController::class, 'edit'])->name('forums.edit');
    Route::put('/forums/{forum}', [ForumController::class, 'update'])->name('forums.update');
    Route::delete('/forums/{forum}', [ForumController::class, 'destroy'])->name('forums.destroy');

    // Forum Topics Routes
    Route::get('/forums/{forum}/topics/create', [ForumTopicController::class, 'create'])->name('topics.create');
    Route::post('/forums/{forum}/topics', [ForumTopicController::class, 'store'])->name('topics.store');
    Route::get('/forums/{forum}/topics/{topic}', [ForumTopicController::class, 'show'])->name('topics.show');
    Route::get('/forums/{forum}/topics/{topic}/edit', [ForumTopicController::class, 'edit'])->name('topics.edit');
    Route::put('/forums/{forum}/topics/{topic}', [ForumTopicController::class, 'update'])->name('topics.update');
    Route::delete('/forums/{forum}/topics/{topic}', [ForumTopicController::class, 'destroy'])->name('topics.destroy');

    // Forum Posts Routes
    Route::post('/forums/{forum}/topics/{topic}/posts', [ForumPostController::class, 'store'])->name('posts.store');
    Route::get('/forums/{forum}/topics/{topic}/posts/{post}/edit', [ForumPostController::class, 'edit'])->name('posts.edit');
    Route::put('/forums/{forum}/topics/{topic}/posts/{post}', [ForumPostController::class, 'update'])->name('posts.update');
    Route::delete('/forums/{forum}/topics/{topic}/posts/{post}', [ForumPostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/forums/{forum}/topics/{topic}/posts/{post}/solution', [ForumPostController::class, 'markAsSolution'])->name('posts.solution');
});
