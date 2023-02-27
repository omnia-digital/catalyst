<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AuthSocialController;
use App\Http\Controllers\MuxWebhooksController;
use App\Http\Controllers\StripeWebhooksController;
use App\Http\Livewire\Channel\ChannelDetail;
use App\Http\Livewire\Channel\Channels;
use App\Http\Livewire\Channel\FindChannel;
use App\Http\Livewire\Channel\UpdateChannel;
use App\Http\Livewire\Episode\CreateEpisode;
use App\Http\Livewire\Episode\Episodes;
use App\Http\Livewire\Episode\Templates;
use App\Http\Livewire\Episode\UpdateTemplate;
use App\Http\Livewire\Person\People;
use App\Http\Livewire\Player\PlayerDetail;
use App\Http\Livewire\Player\Players;
use App\Http\Livewire\Playlist\Playlists;
use App\Http\Livewire\Playlist\UpdatePlaylist;
use App\Http\Livewire\Series\Series;
use App\Http\Livewire\Series\UpdateSeries;
use App\Http\Livewire\Setting\EpisodeSetting;
use App\Http\Livewire\Setting\PlayerSetting;
use App\Http\Livewire\Setting\StreamingSetting;
use App\Http\Livewire\Setting\VideoSetting;
use App\Http\Livewire\Stream\Streams;
use App\Http\Livewire\Stream\StreamTargets;
use App\Http\Livewire\Stream\UpdateStreamTarget;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/channels/find', FindChannel::class)->name('channels.find');
Route::get('/channels/{channel:slug}', ChannelDetail::class)->name('channels.show');

Route::get('/attachments/{media}/download', [AttachmentController::class, 'download'])->name('attachments.download');
Route::get('/attachments/{media}/static-download', [AttachmentController::class, 'staticDownload'])->name('attachments.static-download');

Route::middleware(['auth', 'verified', 'subscribed', 'info-filled'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::get('/episodes', Episodes::class)->name('episodes');
    Route::get('/episodes/create', CreateEpisode::class)->name('episodes.create');
    Route::get('/episodes/{episode}', Episodes::class)->name('episodes.show');

    Route::get('/episode-templates', Templates::class)->name('episode-templates');
    Route::get('/episode-templates/{episodeTemplate}/update', UpdateTemplate::class)->name('episode-templates.update');

    Route::get('/players', Players::class)->name('players');
    Route::get('/players/{player}', PlayerDetail::class)->name('players.show');

    Route::get('/streams', Streams::class)->name('streams');
    Route::get('/stream-targets', StreamTargets::class)->name('stream-targets');
    Route::get('/stream-targets/{streamTarget}/update', UpdateStreamTarget::class)->name('stream-targets.update');

    Route::get('/channels', Channels::class)->name('channels');
    Route::get('/channels/{channel}/update', UpdateChannel::class)->name('channels.update');

    Route::get('/people', People::class)->name('people');
    Route::get('/people/{person}', People::class)->name('people.show');

    Route::get('/series', Series::class)->name('series');
    Route::get('/series/{series}', UpdateSeries::class)->name('series.update');

    Route::get('/playlists', Playlists::class)->name('playlists');
    Route::get('/playlists/{playlist}', UpdatePlaylist::class)->name('playlists.update');

    Route::get('/settings', fn() => redirect()->route('settings.video'))->name('settings');
    Route::get('/settings/video', VideoSetting::class)->name('settings.video');
    Route::get('/settings/streaming', StreamingSetting::class)->name('settings.streaming');
    Route::get('/settings/player', PlayerSetting::class)->name('settings.player');
    Route::get('/settings/episode', EpisodeSetting::class)->name('settings.episode');
});

Route::post('webhooks/mux', MuxWebhooksController::class);

Route::post('spark/webhook', [StripeWebhooksController::class, 'handleWebhook']);

Route::get('/auth/redirect', [AuthSocialController::class, 'redirect'])->name('auth.social');
Route::get('/auth/callback', [AuthSocialController::class, 'callback']);

Route::view('/test-embed-player', 'test');
//Route::view('/test-embed-playlist', 'test-playlist');
