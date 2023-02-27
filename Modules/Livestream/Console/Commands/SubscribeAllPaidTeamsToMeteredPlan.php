<?php

namespace App\Console\Commands;

use App\Omnia;
use App\Services\SubscriptionService;
use App\Team;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * Class SubscribeAllPaidTeamsToMeteredPlan
 * Subscribe given Team/User or All Teams/Users to the required plans for the modules they have subscriptions with already
 *
 * @package App\Console\Commands
 */
class SubscribeAllPaidTeamsToMeteredPlan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscribe-all-paid-teams-to-metered-plan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('[START] - ' . __CLASS__);

        try {
            // get all of the teams
            $allTeams = Team::all();
            $teamsToSubscribe = collect();
            $subscriptionService = new SubscriptionService();

            // foreach team
            foreach ($allTeams as $team) {
                $subscriptions = $team->subscriptions()->get();

                // run through each modules metered billing
                $meteredPlan = $subscriptions->first(function($subscription) {
                    return $subscription->stripe_plan === 'omnia-metered';
                });
                if (!empty($meteredPlan)) {
                    continue; // skip it if it already has omnia-metered
                } else {
                    $paidSubscription = $subscriptions->first(function($subscription) {
                        return Omnia::getPlanById($subscription->stripe_plan,true)->price > 0 ;
                    });
                    if (!empty($paidSubscription)) {
                        $teamsToSubscribe->push($team);
                    }
                }

            }

            if ($teamsToSubscribe->isNotEmpty()) {
                $data = array();
                foreach($teamsToSubscribe as $team) {
                    $subscriptionService->subscribeToPlan($team,Omnia::getPlanById('omnia-metered',true), $data);
                }
            }

            // when a livestream-metered invoice is created

            // if team cancels their plan, make sure to charge them on there last day for the storage they are using
                // notify them that we will delete all of their storage until they have only 5GB remaining,
                    // and then they can keep that, but we will delete each old episode after that

        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        Log::info('[FINISHED] - ' . __CLASS__);

    }
}
