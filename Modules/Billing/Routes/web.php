<?php


use Modules\Billing\Http\Livewire\Pages\Billing\Billing;
use Modules\Billing\Http\Livewire\Pages\Subscriptions\Index as SubscriptionPage;

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

Route::name('billing.')
     ->prefix('billing')
     ->group(function () {
         Route::get('billing', Billing::class)
              ->name('billing'); // stripe billing page
         Route::get('/subscription', SubscriptionPage::class)
              ->withoutMiddleware('subscribed')
              ->name('subscription'); // chargent billing

     });
