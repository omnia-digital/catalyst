<?php

use Modules\Resources\Http\Livewire\Pages\Bookmarks\Index as BookmarkIndex;
use Modules\Resources\Http\Livewire\Pages\Resources\Edit;
use Modules\Resources\Http\Livewire\Pages\Resources\Index;
use Modules\Resources\Http\Livewire\Pages\Resources\Show;
use Modules\Social\Http\Middleware\GuestAccessMiddleware;

Route::name('resources.')->prefix('resources')->middleware([GuestAccessMiddleware::class])->group(function () {
    Route::get('/', Index::class)->name('home');
    Route::get('bookmarks', BookmarkIndex::class)->name('bookmarks');
    Route::get('{resource}', Show::class)->name('show');
    Route::get('{resource}/edit', Edit::class)->name('edit');
});
