<?php

namespace Modules\Livestream\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Livestream\Models\Team;

class CreateStripeMeteredSubscriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private Team $team
    ) {
    }

    public function handle()
    {
        $this->team
            ->newSubscription('omnia-metered', config('metered.stripe_id'))
            ->quantity(null)
            ->create();
    }
}
