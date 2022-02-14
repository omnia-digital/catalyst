<?php

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
//        return redirect()->route('dashboard');
    });

    Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware(['auth', 'verified'])->group(function() {
//        Route::get('/home', function () {
//            return "Home";
//        })->name('home');

        Route::get('/teams', App\Http\Livewire\Teams::class)->name('teams.home');


        Route::get('/profile', function () {
            return "Profile";
        })->name('user.profile');

        Route::get('/messages', function () {
            return "Messages";
        })->name('messages');

        Route::get('/contacts', function () {
            return "Contacts";
        })->name('contacts');

        Route::get('/notifications', function () {
            return "Notifications";
        })->name('notifications');

        Route::get('/projects', function () {
            return "Projects";
        })->name('projects');

        Route::get('/my-projects', function () {
            return "My Projects";
        })->name('my-projects');

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

