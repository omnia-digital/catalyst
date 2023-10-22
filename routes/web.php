<?php

use Illuminate\Support\Facades\Route;
use OmniaDigital\CatalystCore\Http\Controllers\HandleStripeConnectRefreshUrlController;
use OmniaDigital\CatalystCore\Livewire\UserNotifications;

Route::get('r/{url?}', function ($url) {
    return redirect($url);
})->where('url', '.*');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('notifications', UserNotifications::class)->name('notifications');
    Route::get('account', OmniaDigital\CatalystCore\Livewire\Pages\Account\Index::class)->name('account');
    Route::name('media.')->prefix('media')->group(function () {
        Route::get('/', OmniaDigital\CatalystCore\Livewire\Pages\Media\Index::class)->name('index');
    });
});



Route::get('/', function () {
    return redirect()->route('catalyst-social.home');
});
