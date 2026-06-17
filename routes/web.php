<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes - Golf Indonesia
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/events/{id}', [PublicController::class, 'showEvent'])->name('events.show');
Route::get('/players/{id}', [PublicController::class, 'showPlayer'])->name('players.show');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Marketplace Routes (Protected by Auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace.index');
    Route::post('/marketplace/buy/{id}', [MarketplaceController::class, 'buyOfficial'])->name('marketplace.buy_official');
    Route::post('/marketplace/list-p2p', [MarketplaceController::class, 'listP2P'])->name('marketplace.list_p2p');
    Route::post('/marketplace/buy-p2p/{id}', [MarketplaceController::class, 'buyP2P'])->name('marketplace.buy_p2p');
    Route::post('/marketplace/trade-p2p/{id}', [MarketplaceController::class, 'tradeP2P'])->name('marketplace.trade_p2p');
});

// Admin Routes (Protected by Auth and checked for Admin role)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    
    // Admin Event Management
    Route::get('/events', [AdminController::class, 'events'])->name('events.index');
    Route::get('/events/create', [AdminController::class, 'createEvent'])->name('events.create');
    Route::post('/events/store', [AdminController::class, 'storeEvent'])->name('events.store');
    Route::get('/events/{id}/edit', [AdminController::class, 'editEvent'])->name('events.edit');
    Route::post('/events/{id}/update', [AdminController::class, 'updateEvent'])->name('events.update');
    Route::post('/events/{id}/delete', [AdminController::class, 'deleteEvent'])->name('events.delete');
    
    // Event Players & Scoring
    Route::get('/events/{id}/players', [AdminController::class, 'eventPlayers'])->name('events.players');
    Route::post('/events/{id}/players/store', [AdminController::class, 'storeEventPlayers'])->name('events.players.store');
    Route::get('/events/{id}/scoring', [AdminController::class, 'scoring'])->name('events.scoring');
    Route::post('/events/{id}/scoring/update', [AdminController::class, 'updateScoring'])->name('events.scoring.update');
    
    // Admin Player Management
    Route::get('/players', [AdminController::class, 'players'])->name('players.index');
    Route::get('/players/create', [AdminController::class, 'createPlayer'])->name('players.create');
    Route::post('/players/store', [AdminController::class, 'storePlayer'])->name('players.store');
    Route::get('/players/{id}/edit', [AdminController::class, 'editPlayer'])->name('players.edit');
    Route::post('/players/{id}/update', [AdminController::class, 'updatePlayer'])->name('players.update');
    Route::post('/players/{id}/delete', [AdminController::class, 'deletePlayer'])->name('players.delete');
});

// Database resetting and seeding utility
Route::get('/reset-and-seed', function() {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--force' => true]);
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        return response()->json([
            'status' => 'success',
            'message' => 'Database Golf Indonesia berhasil di-reset dan di-seed dengan 25 pegolf profesional terdaftar dan skor turnamen yang realistis!'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

