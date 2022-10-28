<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Support\StripeConnect\StripeConnect;
use Illuminate\Http\Request;

class HandleStripeConnectRefreshUrlController extends Controller
{
    public function __invoke(Request $request)
    {
        /** @var Team $team */
        $team = $request->user()->currentTeam;

        if (!$team) {
            return route('social.home');
        }

        $accountLink = app(StripeConnect::class)->createAccountLink(
            accountStripeId: $team->stripe_connect_id,
            returnUrl: route('social.teams.subscriptions', $team)
        );

        return redirect()->to($accountLink->url);
    }
}
