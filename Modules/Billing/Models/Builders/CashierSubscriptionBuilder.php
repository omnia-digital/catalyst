<?php

namespace Modules\Subscriptions\Models\Builders;

use Laravel\Cashier\SubscriptionBuilder;
use Stripe\Subscription as StripeSubscription;

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
     * @param \Stripe\Subscription $stripeSubscription
     * @return \Laravel\Cashier\Subscription
     */
    protected function createSubscription(StripeSubscription $stripeSubscription)
    {
        if ($subscription = $this->owner->subscriptions()->where('stripe_id', $stripeSubscription->id)->first()) {
            return $subscription;
        }

        /** @var \Stripe\SubscriptionItem $firstItem */
        $firstItem = $stripeSubscription->items->first();
        $isSinglePrice = $stripeSubscription->items->count() === 1;

        /** @var \Laravel\Cashier\Subscription $subscription */
        $subscription = $this->owner->subscriptions()->create([
            'team_id' => $this->teamId,
            'name' => $this->name,
            'stripe_id' => $stripeSubscription->id,
            'stripe_status' => $stripeSubscription->status,
            'stripe_price' => $isSinglePrice ? $firstItem->price->id : null,
            'quantity' => $isSinglePrice ? ($firstItem->quantity ?? null) : null,
            'trial_ends_at' => !$this->skipTrial ? $this->trialExpires : null,
            'ends_at' => null,
        ]);

        /** @var \Stripe\SubscriptionItem $item */
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
