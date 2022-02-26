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

    use Modules\Resources\Http\Livewire\Pages\Home;

    Route::name('resources.')->prefix('resources')->group(function () {
        Route::get('/', Home::class)->name('home');
    });
