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
use Modules\Games\Http\Livewire\Home;

Route::name('games.')->prefix('games')->middleware(['auth', 'verified'])->group(function() {
    Route::get('/', Home::class)->name('home');
    Route::get('/feeds', \Modules\Games\Http\Livewire\Feeds::class)->name('feeds');
    Route::get('/{slug}', [GamesController::class, 'show'])->name('show');
//    Route::get('/games/{slug}', 'GamesController@show')->name('reviews');
//    Route::get('/games/{slug}', 'GamesController@show')->name('coming-soon');
});
