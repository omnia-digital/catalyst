<?php

use Modules\Games\Http\Controllers\GamesController;
use Modules\Games\Http\Livewire\Feeds;
use Modules\Games\Http\Livewire\Home;
use Modules\Social\Http\Middleware\GuestAccessMiddleware;

Route::name('games.')->prefix('games')->middleware([GuestAccessMiddleware::class, 'verified'])->group(function() {
//    Route::get('/', Home::class)->name('home');
//    Route::get('/', Feeds::class)->name('home');
    Route::get('/', Home::class)->name('home');
    Route::get('/igdb', \Modules\Games\Http\Livewire\Igdb::class)->name('igdb');
    Route::get('/feeds', Feeds::class)->name('feeds');
    Route::name('games.')->prefix('/g')->group(function() {
        Route::get('/{slug}', \Modules\Games\Http\Livewire\Show::class)->name('show');
    });
});
