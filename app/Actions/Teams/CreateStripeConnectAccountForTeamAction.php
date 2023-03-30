<?php

namespace App\Actions\Teams;

use App\Models\Team;
use App\Support\StripeConnect\StripeConnect;
use Exception;

class CreateStripeConnectAccountForTeamAction
{
    public function execute(Team $team): void
    {
        if ($team->hasStripeConnectAccount()) {
            throw new Exception('This team already had a Stripe Connect account');
        }

        $stripeConnectAccount = app(StripeConnect::class)->createAccount($team->owner->email);

        $team->update([
            'stripe_connect_id' => $stripeConnectAccount->id,
        ]);
    }
}
