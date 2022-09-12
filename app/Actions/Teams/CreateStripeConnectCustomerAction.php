<?php

namespace App\Actions\Teams;

use App\Models\StripeConnectCustomer;
use App\Models\Team;
use App\Models\User;
use App\Support\StripeConnect\StripeConnect;
use Illuminate\Foundation\Auth\User as Authenticatable;

/** @note We are not using this currently. Save for future when we want teams to create custom plans */
class CreateStripeConnectCustomerAction
{
    public function execute(Team $team, User|Authenticatable $user): StripeConnectCustomer
    {
        if ($user->isStripeConnectCustomerOf($team)) {
            return $user->stripeConnectCustomerOf($team);
        }

        $stripeCustomer = app(StripeConnect::class)->createCustomer(
            stripeAccountId: $team->stripe_connect_id,
            email: $user->email
        );

        return $user->stripeConnectCustomers()->create([
            'team_id' => $team->id,
            'stripe_customer_id' => $stripeCustomer->id
        ]);
    }
}
