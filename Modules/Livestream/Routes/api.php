<?php

use Illuminate\Support\Facades\Route;
use Modules\Livestream\Http\Controllers\Api\EmbedPlayersController;
use Modules\Livestream\Http\Controllers\Api\EmbedPlaylistController;
use Modules\Livestream\Http\Controllers\Api\VideoViewsController;

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

Route::post('/videos/view', [VideoViewsController::class, 'dispatchVideoView'])->name('dispatch-video-view');

Route::get('/embed-players/{player}', [EmbedPlayersController::class, 'load'])->name('players.embed');
Route::get('/embed-players/{player}/gallery', [EmbedPlayersController::class, 'loadGallery']);

Route::get('/embed-playlist/{playlist}', [EmbedPlaylistController::class, 'index'])->name('playlists.embed');