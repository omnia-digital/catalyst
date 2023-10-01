<?php

use Illuminate\Support\Facades\Route;
use Modules\Livestream\Http\Controllers\AttachmentController;
use Modules\Livestream\Http\Controllers\AuthSocialController;
use Modules\Livestream\Http\Controllers\MuxWebhooksController;
use Modules\Livestream\Http\Controllers\StripeWebhooksController;
use Modules\Livestream\Http\Livewire\Channel\ChannelDetail;
use Modules\Livestream\Http\Livewire\Channel\Channels;
use Modules\Livestream\Http\Livewire\Channel\FindChannel;
use Modules\Livestream\Http\Livewire\Channel\UpdateChannel;
use Modules\Livestream\Http\Livewire\Episode\CreateEpisode;
use Modules\Livestream\Http\Livewire\Episode\Episodes;
use Modules\Livestream\Http\Livewire\Episode\Templates;
use Modules\Livestream\Http\Livewire\Episode\UpdateTemplate;
use Modules\Livestream\Http\Livewire\Person\People;
use Modules\Livestream\Http\Livewire\Player\PlayerDetail;
use Modules\Livestream\Http\Livewire\Player\Players;
use Modules\Livestream\Http\Livewire\Playlist\Playlists;
use Modules\Livestream\Http\Livewire\Playlist\UpdatePlaylist;
use Modules\Livestream\Http\Livewire\Series\Series;
use Modules\Livestream\Http\Livewire\Series\UpdateSeries;
use Modules\Livestream\Http\Livewire\Setting\EpisodeSetting;
use Modules\Livestream\Http\Livewire\Setting\PlayerSetting;
use Modules\Livestream\Http\Livewire\Setting\StreamingSetting;
use Modules\Livestream\Http\Livewire\Setting\VideoSetting;
use Modules\Livestream\Http\Livewire\Stream\Streams;
use Modules\Livestream\Http\Livewire\Stream\StreamTargets;
use Modules\Livestream\Http\Livewire\Stream\UpdateStreamTarget;
use Modules\Social\Http\Middleware\GuestAccessMiddleware;

//Route::get('/', function () {
//    return redirect()->route('dashboard');
//});
Route::name('livestream.')
    ->prefix('livestream')
    ->middleware([GuestAccessMiddleware::class, 'verified'])
    ->group(function () {
        Route::get('/channels/find', FindChannel::class)
            ->name('channels.find');
        Route::get('/channels/{channel:slug}', ChannelDetail::class)
            ->name('channels.show');

        Route::get('/attachments/{media}/download', [AttachmentController::class, 'download'])
            ->name('attachments.download');
        Route::get('/attachments/{media}/static-download', [AttachmentController::class, 'staticDownload'])
            ->name('attachments.static-download');

        Route::middleware(['auth', 'verified', 'subscribed', 'info-filled'])
            ->group(function () {
                Route::view('/dashboard', 'dashboard')
                    ->name('dashboard');

                Route::get('/episodes', Episodes::class)
                    ->name('episodes');
                Route::get('/episodes/create', CreateEpisode::class)
                    ->name('episodes.create');
                Route::get('/episodes/{episode}', Episodes::class)
                    ->name('episodes.show');

                Route::get('/episode-templates', Templates::class)
                    ->name('episode-templates');
                Route::get('/episode-templates/{episodeTemplate}/update', UpdateTemplate::class)
                    ->name('episode-templates.update');

                Route::get('/players', Players::class)
                    ->name('players');
                Route::get('/players/{player}', PlayerDetail::class)
                    ->name('players.show');

                Route::get('/streams', Streams::class)
                    ->name('streams');
                Route::get('/stream-targets', StreamTargets::class)
                    ->name('stream-targets');
                Route::get('/stream-targets/{streamTarget}/update', UpdateStreamTarget::class)
                    ->name('stream-targets.update');

                Route::get('/channels', Channels::class)
                    ->name('channels');
                Route::get('/channels/{channel}/update', UpdateChannel::class)
                    ->name('channels.update');

                Route::get('/people', People::class)
                    ->name('people');
                Route::get('/people/{person}', People::class)
                    ->name('people.show');

                Route::get('/series', Series::class)
                    ->name('series');
                Route::get('/series/{series}', UpdateSeries::class)
                    ->name('series.update');

                Route::get('/playlists', Playlists::class)
                    ->name('playlists');
                Route::get('/playlists/{playlist}', UpdatePlaylist::class)
                    ->name('playlists.update');

                Route::get('/settings', fn() => redirect()->route('settings.video'))
                    ->name('settings');
                Route::get('/settings/video', VideoSetting::class)
                    ->name('settings.video');
                Route::get('/settings/streaming', StreamingSetting::class)
                    ->name('settings.streaming');
                Route::get('/settings/player', PlayerSetting::class)
                    ->name('settings.player');
                Route::get('/settings/episode', EpisodeSetting::class)
                    ->name('settings.episode');
            });

        Route::post('webhooks/mux', MuxWebhooksController::class);

        Route::post('spark/webhook', [StripeWebhooksController::class, 'handleWebhook']);

        Route::get('/auth/redirect', [AuthSocialController::class, 'redirect'])
            ->name('auth.social');
        Route::get('/auth/callback', [AuthSocialController::class, 'callback']);

        Route::view('/test-embed-player', 'test');
        //Route::view('/test-embed-playlist', 'test-playlist');
    });
