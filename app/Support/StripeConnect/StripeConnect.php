<?php

namespace App\Support\StripeConnect;

use Stripe\Account;
use Stripe\AccountLink;
use Stripe\StripeClient;

class StripeConnect
{
    protected StripeClient $stripeClient;

    public function __construct(string $secret, protected string $refreshUrl)
    {
        $this->stripeClient = new StripeClient($secret);
    }

    public function createAccount(string $email): Account
    {
        return $this->stripeClient
            ->accounts
            ->create([
                'type' => 'standard',
                'email' => $email,
            ]);
    }

    public function createAccountLink(string $accountStripeId, string $returnUrl): AccountLink
    {
        return $this->stripeClient->accountLinks->create(
            [
                'account' => $accountStripeId,
                'refresh_url' => $this->refreshUrl,
                'return_url' => $returnUrl,
                'type' => 'account_onboarding',
            ]
        );
    }

    public function getAccount(string $stripeAccountId): Account
    {
        return $this->stripeClient->accounts->retrieve($stripeAccountId);
    }

    /** @note We are not using this currently. Save for future when we want teams to create custom plans */
    //public function createProduct(string $stripeAccountId, string $name, ?string $description = null): Product
    //{
    //    $data = [
    //        'name' => $name,
    //    ];
    //
    //    if ($description) {
    //        $data['description'] = $description;
    //    }
    //
    //    return $this->stripeClient->products->create($data, ['stripe_account' => $stripeAccountId]);
    //}

    /** @note We are not using this currently. Save for future when we want teams to create custom plans */
    //public function createPrice(string $stripeAccountId, string $productId, string $amount, string $billingPeriod): Price
    //{
    //    return $this->stripeClient->prices->create([
    //        'unit_amount' => $amount * 100,
    //        'currency' => 'usd',
    //        'recurring' => ['interval' => $billingPeriod],
    //        'product' => $productId,
    //    ], ['stripe_account' => $stripeAccountId]);
    //}

    /** @note We are not using this currently. Save for future when we want teams to create custom plans */
    //public function newSubscription(string $stripeAccountId, string $priceId, string $customerId): Subscription
    //{
    //    return $this->stripeClient->subscriptions->create([
    //        'customer' => $customerId,
    //        'items' => [
    //            ['price' => $priceId],
    //        ],
    //        'expand' => ['latest_invoice.payment_intent'],
    //    ], ['stripe_account' => $stripeAccountId]);
    //}

    /** @note We are not using this currently. Save for future when we want teams to create custom plans */
    //public function createCustomer(string $stripeAccountId, string $email): Customer
    //{
    //    return $this->stripeClient->customers->create([
    //        'email' => $email
    //    ], ['stripe_account' => $stripeAccountId]);
    //}
}
