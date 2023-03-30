<?php

use Illuminate\Database\Migrations\Migration;
use Laravel\Cashier\Subscription;
use Laravel\Cashier\SubscriptionItem;

class MigrateTeamSubscriptionsToSubscriptionsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Truncate the subscriptions + subscription items tables first
        Subscription::query()->truncate();
        SubscriptionItem::query()->truncate();

        $teamSubscriptions = DB::table('team_subscriptions')->get();

        foreach ($teamSubscriptions as $teamSubscription) {
            $subscription = Subscription::create([
                'name' => $teamSubscription->name,
                'team_id' => $teamSubscription->team_id,
                'stripe_status' => $teamSubscription->ends_at ? \Stripe\Subscription::STATUS_CANCELED : \Stripe\Subscription::STATUS_ACTIVE,
                'stripe_id' => $teamSubscription->stripe_id,
                'stripe_plan' => $teamSubscription->stripe_plan,
                'quantity' => $teamSubscription->quantity,
                'trial_ends_at' => null,
                'ends_at' => $teamSubscription->ends_at,
            ]);

            $subscription->items()->create([
                'stripe_id' => $subscription->stripe_id,
                'stripe_plan' => $subscription->stripe_plan,
                'quantity' => $subscription->quantity,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
