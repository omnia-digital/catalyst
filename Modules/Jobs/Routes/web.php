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

use Modules\Jobs\Http\Livewire\Pages\Home;

Route::name('jobs.')->prefix('jobs')->middleware(['auth','verified'])->group(function () {
    Route::get('/', Home::class)->name('home');
    Route::get('/create', Home::class)->name('create');
});
