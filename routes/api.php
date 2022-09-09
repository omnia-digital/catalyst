<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Subscriptions\Models\SubscriptionType;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('subscriptions', function (Request $request) {
    $user = User::findByEmail($request->email);

    $user->subscription()->firstOrCreate([
        'subscription_type_id' => SubscriptionType::where('slug', $request->subscription_type)->first()->id,
        'chargent_order_id' => $request->chargent_order_object_id,
        'card_type' => $request->card_type,
        'last_4' => $request->last_4,
        'starts_at' => now(),
        'next_invoice_at' => now()->addMonth()
    ]);
});
