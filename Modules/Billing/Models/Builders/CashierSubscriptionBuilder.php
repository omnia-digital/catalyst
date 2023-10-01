<?php

namespace Modules\Billing\Models\Builders;

use Laravel\Cashier\Subscription;
use Laravel\Cashier\SubscriptionBuilder;
use Stripe\Subscription as StripeSubscription;
use Stripe\SubscriptionItem;

class CashierSubscriptionBuilder extends SubscriptionBuilder
{
    protected ?int $teamId = null;

    public function teamId(int $teamId): self
    {
        $this->teamId = $teamId;

        return $this;
    }

    /**
     * Create the Eloquent Subscription.
     *
     * @return Subscription
     */
    protected function createSubscription(StripeSubscription $stripeSubscription)
    {
        if ($subscription = $this->owner->subscriptions()->where('stripe_id', $stripeSubscription->id)->first()) {
            return $subscription;
        }

        /** @var SubscriptionItem $firstItem */
        $firstItem = $stripeSubscription->items->first();
        $isSinglePrice = $stripeSubscription->items->count() === 1;

        /** @var Subscription $subscription */
        $subscription = $this->owner->subscriptions()->create([
            'team_id' => $this->teamId,
            'name' => $this->name,
            'stripe_id' => $stripeSubscription->id,
            'stripe_status' => $stripeSubscription->status,
            'stripe_price' => $isSinglePrice ? $firstItem->price->id : null,
            'quantity' => $isSinglePrice ? ($firstItem->quantity ?? null) : null,
            'trial_ends_at' => ! $this->skipTrial ? $this->trialExpires : null,
            'ends_at' => null,
        ]);

        /** @var SubscriptionItem $item */
        foreach ($stripeSubscription->items as $item) {
            $subscription->items()->create([
                'stripe_id' => $item->id,
                'stripe_product' => $item->price->product,
                'stripe_price' => $item->price->id,
                'quantity' => $item->quantity ?? null,
            ]);
        }

        return $subscription;
    }
}
