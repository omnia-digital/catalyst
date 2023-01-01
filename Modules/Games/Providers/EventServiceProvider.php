<?php

namespace Modules\Games\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Games\Events\IGDBGameWasRetrieved;
use Modules\Games\Listeners\SyncIGDBGameWithDb;
use Modules\Games\Models\IGDB\Game as IGDBGame;
use Modules\Games\Observers\IGDBGameObserver;

class EventServiceProvider extends ServiceProvider
{
//    protected $observers = [
//        IGDBGame::class => [
//            IGDBGameObserver::class,
//        ]
//    ];
//
//    protected $listen = [
//        IGDBGameWasRetrieved::class => [
//            SyncIGDBGameWithDb::class,
//        ],
//    ];
}
