<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Modules\Games\Http\Controllers\GamesController;
use Modules\Games\Http\Livewire\Feeds;
use Modules\Games\Http\Livewire\Home;
use Modules\Social\Http\Middleware\GuestAccessMiddleware;

Route::name('games.')->prefix('games')->middleware([GuestAccessMiddleware::class, 'verified'])->group(function() {
//    Route::get('/', Home::class)->name('home');
    Route::get('/', Feeds::class)->name('home');
    Route::get('/igdb', \Modules\Games\Http\Livewire\Igdb::class)->name('igdb');
    Route::get('/feeds', Feeds::class)->name('feeds');
    Route::get('/{slug}', [GamesController::class, 'show'])->name('show');
//    Route::get('/games/{slug}', 'GamesController@show')->name('reviews');
//    Route::get('/games/{slug}', 'GamesController@show')->name('coming-soon');
});
