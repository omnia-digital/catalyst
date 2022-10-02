<?php

use App\Http\Controllers\HandleStripeConnectRefreshUrlController;
use App\Http\Livewire\UserNotifications;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('social.home');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/notifications', UserNotifications::class)->name('notifications');
});

// Stripe Connect
Route::get('/teams/stripe-connect/refresh', HandleStripeConnectRefreshUrlController::class)->name('teams.stripe-connect.refresh');
