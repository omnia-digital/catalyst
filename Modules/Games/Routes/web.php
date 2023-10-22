<?php

use Modules\Games\Http\Livewire\Home;
use Modules\Games\Http\Livewire\Igdb;
use Modules\Games\Http\Livewire\Show;
use OmniaDigital\CatalystCore\Http\Middleware\GuestAccessMiddleware;

Route::name('games.')->prefix('games')->middleware([GuestAccessMiddleware::class, 'verified'])->group(function () {
//    Route::get('/', Home::class)->name('home');
//    Route::get('/', Feeds::class)->name('home');
    Route::get('/', Home::class)->name('home');
    Route::get('/igdb', Igdb::class)->name('igdb');
    Route::name('games.')->prefix('/g')->group(function () {
        Route::get('/{slug}', Show::class)->name('show');
    });
});
