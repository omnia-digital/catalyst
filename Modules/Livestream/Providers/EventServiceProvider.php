<?php

namespace Modules\Livestream\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamUpdated;
use Modules\Livestream\Events\EpisodeCreatedEvent;
use Modules\Livestream\Events\EpisodeViewedEvent;
use Modules\Livestream\Listeners\CreateEssentialStuffForTeam;
use Modules\Livestream\Listeners\CreateStripeStuffOnTheFirstTeamUpdatedListener;
use Modules\Livestream\Listeners\EnableStream;
use Modules\Livestream\Listeners\TrackSubscriptionCancelledGoalListener;
use Modules\Livestream\Listeners\TrackUserSubscribedGoalListener;
use Modules\Livestream\Listeners\UpdateLastViewedAtListener;
use Modules\Livestream\Models\Episode;
use Modules\Livestream\Observers\EpisodeObserver;
use Spark\Events\SubscriptionCancelled;
use Spark\Events\SubscriptionCreated;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        TeamCreated::class => [
            CreateEssentialStuffForTeam::class,
        ],

        TeamUpdated::class => [
            CreateStripeStuffOnTheFirstTeamUpdatedListener::class,
        ],

        SubscriptionCreated::class => [
            EnableStream::class,
            TrackUserSubscribedGoalListener::class,
        ],

        SubscriptionCancelled::class => [
            TrackSubscriptionCancelledGoalListener::class,
        ],

        EpisodeViewedEvent::class => [
            UpdateLastViewedAtListener::class,
        ],

        EpisodeCreatedEvent::class => [
            //TrackEpisodeCreatedGoalListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Episode::observe(EpisodeObserver::class);
    }
}
