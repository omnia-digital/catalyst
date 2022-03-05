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

    use Modules\Resources\Http\Livewire\Pages\Browse;
    use Modules\Resources\Http\Livewire\Pages\Home;

    Route::name('resources.')->prefix('resources')->middleware(['auth','verified'])->group(function () {
        Route::get('/', Home::class)->name('home');
        Route::get('browse', Browse::class)->name('browse');
        Route::get('bookmarks', Home::class)->name('bookmarks');
    });
