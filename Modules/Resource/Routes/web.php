<?php

use Modules\Resource\Http\Livewire\ListResources;
use Modules\Resource\Http\Livewire\ShowResource;

Route::middleware(['web', 'auth'])->prefix('resources')->group(function() {
    Route::get('/', ListResources::class)->name('resources.list-resources');
    Route::get('/{resource}', ShowResource::class)->name('resources.show-resource');
});
