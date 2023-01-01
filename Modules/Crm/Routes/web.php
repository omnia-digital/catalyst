<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('crm.')->prefix('crm')->group(function() {
    Route::get('', \Modules\Crm\Http\Livewire\Pages\People\Index::class)->name('home');
    Route::get('people', \Modules\Crm\Http\Livewire\Pages\People\Index::class)->name('people');
    Route::get('reviews', \Modules\Crm\Http\Livewire\Pages\Reviews\Index::class)->name('reviews');
});
