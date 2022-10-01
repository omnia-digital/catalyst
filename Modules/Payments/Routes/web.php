<?php


use Modules\Payments\Http\Livewire\Pages\Billing\Billing;
use Modules\Payments\Http\Livewire\Pages\Payments\Index as SubscriptionPage;

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

Route::name('payments.')
     ->prefix('subscriptions')
     ->group(function () {
         Route::get('/', 'SubscriptionsController@index');
         Route::get('billing', Billing::class)
              ->name('billing'); // stripe billing page
         Route::get('/subscription', SubscriptionPage::class)
              ->withoutMiddleware('subscribed')
              ->name('subscription'); // chargent billing

     });
