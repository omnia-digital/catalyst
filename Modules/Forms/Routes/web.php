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

Route::name('forms.')->prefix('forms')->group(function () {
    Route::get('/forms/{form}', \Modules\Forms\Http\Livewire\Form::class)->name('form');
});
