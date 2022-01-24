<?php

    use Illuminate\Foundation\Application;
    use Illuminate\Support\Facades\Route;
    use Inertia\Inertia;
    use Modules\Social\Http\Controllers\Pages\Social\Home;

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

    Route::get('/', function (\Illuminate\Http\Request $request) {
        return redirect('social/home');
    });

    Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::middleware(['auth:sanctum', 'verified'])->group(function() {

//        Route::get('/home', [Home::class,'show'])->name('home');

        Route::get('/messages', [Home::class,'show'])->name('messages');
        Route::get('/notifications', [Home::class,'show'])->name('notifications');
        Route::get('/projects', [Home::class,'show'])->name('projects');
        Route::get('/groups', [Home::class,'show'])->name('groups');
        Route::get('/learn', [Home::class,'show'])->name('learn');
        Route::get('/marketplace', [Home::class,'show'])->name('marketplace');
    });

