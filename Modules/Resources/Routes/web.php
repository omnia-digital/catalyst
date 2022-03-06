<?php

use Modules\Resources\Http\Livewire\ListResources;
use Modules\Resource\Http\Livewire\ShowResource;
use Modules\Resources\Http\Livewire\Pages\Browse;
use Modules\Resources\Http\Livewire\Pages\Home;

Route::name('resources.')->prefix('resources')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', Home::class)->name('home');
    Route::get('browse', Browse::class)->name('browse');
    Route::get('bookmarks', Home::class)->name('bookmarks');
    Route::get('/', ListResources::class)->name('resources.list-resources');
    Route::get('/{resource}', ShowResource::class)->name('resources.show-resource');
});
