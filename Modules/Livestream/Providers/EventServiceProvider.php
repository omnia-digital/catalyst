<?php namespace App\Providers;

use App\Events\EpisodeCreatedEvent;
use App\Events\EpisodeViewedEvent;
use App\Listeners\CreateStripeStuffOnTheFirstTeamUpdatedListener;
use App\Listeners\EnableStream;
use App\Listeners\CreateEssentialStuffForTeam;
use App\Listeners\TrackEpisodeCreatedGoalListener;
use App\Listeners\TrackSubscriptionCancelledGoalListener;
use App\Listeners\TrackUserSubscribedGoalListener;
use App\Listeners\UpdateEpisodeViews;
use App\Listeners\UpdateLastViewedAtListener;
use App\Models\Episode;
use App\Observers\EpisodeObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamUpdated;
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
            CreateEssentialStuffForTeam::class
        ],

        TeamUpdated::class => [
            CreateStripeStuffOnTheFirstTeamUpdatedListener::class,
        ],

        SubscriptionCreated::class => [
            EnableStream::class,
            TrackUserSubscribedGoalListener::class
        ],

        SubscriptionCancelled::class => [
            TrackSubscriptionCancelledGoalListener::class,
        ],

        EpisodeViewedEvent::class => [
            UpdateLastViewedAtListener::class,
        ],

        EpisodeCreatedEvent::class => [
            //TrackEpisodeCreatedGoalListener::class,
        ]
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
