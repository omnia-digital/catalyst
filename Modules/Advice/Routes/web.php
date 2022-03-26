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

use Modules\Advice\Http\Livewire\Pages\Questions\Index;
use Modules\Advice\Http\Livewire\Pages\Questions\Show;

Route::name('advice.')->prefix('advice')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', Index::class)->name('home');
    Route::get('{question}', Show::class)->name('show');
});
