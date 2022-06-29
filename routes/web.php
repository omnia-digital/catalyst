<?php

use App\Http\Livewire\Notifications;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('social.home');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/notifications', Notifications::class)->name('notifications');
});
