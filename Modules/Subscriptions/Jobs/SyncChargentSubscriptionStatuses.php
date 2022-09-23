<?php

namespace Modules\Subscriptions\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Subscriptions\Actions\Salesforce\GetChargentOrderInfoAction;
use Modules\Subscriptions\Models\ChargentSubscription;

class SyncChargentSubscriptionStatuses implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subscriptions = ChargentSubscription::all();

        foreach ($subscriptions as $subscription) {
            (new GetChargentOrderInfoAction)->execute($subscription);
        }
    }
}
