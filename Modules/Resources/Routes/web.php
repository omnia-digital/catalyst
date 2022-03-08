<?php

use Modules\Resources\Http\Livewire\Pages\Browse;
use Modules\Resources\Http\Livewire\Pages\Home;
use Modules\Resources\Http\Livewire\Pages\Show;

Route::name('resources.')->prefix('resources')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', Home::class)->name('home');
    Route::get('browse', Browse::class)->name('browse');
    Route::get('{resource}', Show::class)->name('show');
    Route::get('bookmarks', Home::class)->name('bookmarks');
});
