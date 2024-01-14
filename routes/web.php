<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
//    return redirect()->route('catalyst-social.home');
    return redirect('social');
});

Route::get('login', function () {
    return redirect()->route('filament.admin.auth.login');
})->name('auth.login');

Route::get('login', function () {
    return redirect()->route('filament.admin.auth.login');
})->name('login');
