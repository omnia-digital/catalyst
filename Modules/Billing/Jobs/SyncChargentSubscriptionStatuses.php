<?php

namespace Modules\Billing\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Billing\Actions\Salesforce\GetChargentOrderInfoAction;

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
        foreach (User::all() as $user) {
            if ($user->chargentSubscription) {
                (new GetChargentOrderInfoAction)->execute($user->chargentSubscription()->latest()->first());
            }
        }
    }
}
