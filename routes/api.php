<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user()->makeVisible(['email', 'name', 'profile_photo_url'])->append(['name']);

    return [
        'id' => $user->id,
        'email' => $user->email,
        'name' => $user->name,
        'avatar' => $user->profile_photo_url,
        'profile_photo' => $user->profile_photo_url,
    ];
});
