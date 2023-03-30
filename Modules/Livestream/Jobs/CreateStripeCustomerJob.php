<?php

namespace Modules\Livestream\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use Modules\Livestream\Models\Team;

class CreateStripeCustomerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private Team $team
    ) {
    }

    public function handle()
    {
        Log::debug('Creating Stripe for team ' . $this->team->name);

        $this->team->createAsStripeCustomer([
            'name' => $this->team->name,
            'email' => $this->team->owner->email,
        ]);
    }
}
