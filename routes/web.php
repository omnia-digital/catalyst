<?php

use App\Http\Livewire\Notifications;
use App\Http\Livewire\Pages\Teams\Discover;
use App\Http\Livewire\Pages\Teams\Index;
use App\Http\Livewire\Pages\Teams\Show as ShowTeam;
use Illuminate\Support\Facades\Route;

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

    Route::get('/', function () {
        return redirect()->route('social.home');
    });

    Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::name('teams.')->prefix('teams')->middleware(['auth','verified'])->group(function () {
        Route::get('/', Index::class)->name('home');
        Route::get('/discover', Discover::class)->name('discover');
        Route::get('{team}', ShowTeam::class)->name('show');
    });

    Route::middleware(['auth', 'verified'])->group(function() {

        Route::get('/messages', function () {
            return "Messages";
        })->name('messages');

        Route::get('/notifications', Notifications::class)->name('notifications');

        Route::get('/groups', function () {
            return "Groups";
        })->name('groups');

        Route::get('/favorites', function () {
            return "Favorites";
        })->name('favorites');

        Route::get('/learn', function () {
            return "Learn";
        })->name('learn');

        Route::get('/marketplace', function () {
            return "Marketplace";
        })->name('marketplace');
    });

