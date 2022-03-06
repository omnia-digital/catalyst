<?php

use Modules\Resources\Http\Livewire\ListResources;
use Modules\Resources\Http\Livewire\ShowResource;
use Modules\Resources\Http\Livewire\Pages\Browse;
use Modules\Resources\Http\Livewire\Pages\Home;

Route::name('resources.')->prefix('resources')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', ListResources::class)->name('home');
//    Route::get('/', ListResources::class)->name('resources.list-resources');
    Route::get('browse', Browse::class)->name('browse');
    Route::get('bookmarks', Home::class)->name('bookmarks');
    Route::get('/{resource}', ShowResource::class)->name('resources.show-resource');
});
