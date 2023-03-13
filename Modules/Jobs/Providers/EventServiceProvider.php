<?php

namespace Modules\Jobs\Providers;

use Modules\Jobs\Events\JobPositionWasCreated;
use Modules\Jobs\Events\JobPositionWasCreated;
use Modules\Jobs\Listeners\CreateStripeCustomer;
use Modules\Jobs\Listeners\NotifyAdminsWhenJobCreated;
use Modules\Jobs\Listeners\NotifyContractorsWhenJobCreated;
use Modules\Jobs\Listeners\TweetJob;
use Modules\Jobs\Listeners\UpdateGoogleJobsWhenJobCreated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
            CreateStripeCustomer::class
        ],

        JobPositionWasCreated::class => [
            NotifyContractorsWhenJobCreated::class,
            NotifyAdminsWhenJobCreated::class,
            TweetJob::class,
            UpdateGoogleJobsWhenJobCreated::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
