<?php

use Modules\Feeds\Http\Controllers\ShowFeedController;
use Modules\Feeds\Http\Livewire\Feeds;

Route::name('feeds.')->prefix('feeds')->group(function () {
    Route::get('/', Feeds::class)->name('index');
    Route::get('/{feedPayload}', ShowFeedController::class)->name('show');
});
