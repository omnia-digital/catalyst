<?php

use App\Http\Controllers\HandleStripeConnectRefreshUrlController;
use App\Http\Livewire\Notifications;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('social.home');
});

Route::get('/code', function () {
    return $_GET;
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/notifications', Notifications::class)->name('notifications');
});

// Stripe Connect
Route::get('/teams/stripe-connect/refresh', HandleStripeConnectRefreshUrlController::class)->name('teams.stripe-connect.refresh');
