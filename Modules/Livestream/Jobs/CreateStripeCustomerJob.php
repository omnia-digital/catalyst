<?php

namespace App\Jobs;

use App\Models\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateStripeCustomerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private Team $team
    ){}

    public function handle()
    {
        \Log::debug('Creating Stripe for team ' . $this->team->name);

        $this->team->createAsStripeCustomer([
            'name'  => $this->team->name,
            'email' => $this->team->owner->email
        ]);
    }
}
