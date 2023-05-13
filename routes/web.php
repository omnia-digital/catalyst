<?php

use App\Http\Controllers\HandleStripeConnectRefreshUrlController;
use App\Http\Livewire\Pages\Account\Index as AccountIndex;
use App\Http\Livewire\Pages\Media\Index as MediaIndex;
use App\Http\Livewire\UserNotifications;
use Illuminate\Support\Facades\Route;

Route::get('r/{url?}', function ($url) {
    return redirect($url);
})->where('url', '.*');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('notifications', UserNotifications::class)->name('notifications');
    Route::get('account', AccountIndex::class)->name('account');
    Route::name('media.')->prefix('media')->group(function () {
        Route::get('/', MediaIndex::class)->name('index');
    });
});

// Stripe Connect
Route::get('teams/stripe-connect/refresh', HandleStripeConnectRefreshUrlController::class)->name('teams.stripe-connect.refresh');

Route::get('/', function () {
    return redirect()->route('social.home');
});
