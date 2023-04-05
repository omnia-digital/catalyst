<?php

namespace Modules\Social\Providers;

use App\Contracts\Events\ContributesToUserScore;
use App\Events\BaseEvent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Modules\Billing\Events\NewSubscriptionPayment;
use Modules\Social\Events\LikedUserPost;
use Modules\Social\Events\PostWasLiked;
use Modules\Social\Listeners\TrackContributionToUserScore;
use Modules\Social\Models\Post;
use Modules\Social\Models\Profile;
use Modules\Social\Observers\PostObserver;
use Modules\Social\Observers\ProfileObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        NewSubscriptionPayment::class => [
        ],
        ContributesToUserScore::class => [TrackContributionToUserScore::class]
    ];

    protected $observers = [
        Post::class => PostObserver::class,
        Profile::class => ProfileObserver::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
    }
}
