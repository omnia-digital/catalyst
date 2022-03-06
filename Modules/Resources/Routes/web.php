<?php

use Modules\Resources\Http\Livewire\Pages\Resources\Index;
use Modules\Resources\Http\Livewire\Pages\Resources\Show;

Route::name('resources.')->prefix('resources')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', function() {
        return redirect('index');
    })->name('home');
    Route::get('/', Index::class)->name('index');
//    Route::get('bookmarks', Home::class)->name('bookmarks');
    Route::get('/{resource}', Show::class)->name('show');
});
