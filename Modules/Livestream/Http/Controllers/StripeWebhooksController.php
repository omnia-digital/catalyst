<?php

namespace Modules\Livestream\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\Livestream\Jobs\Billing\AddMeteredBillingInvoiceItemsJob;
use Modules\Livestream\Models\Team;
use Spark\Http\Controllers\WebhookController as SparkWebhookController;

class StripeWebhooksController extends SparkWebhookController
{
    /**
     * Handle When an Invoice is Created. This is here to pause the invoice,
     * add monthly items (metered billing), then resume invoice payment
     *
     *
     * @return Response|Response
     */
    public function handleInvoiceCreated(array $payload)
    {
        /** @var Team $customer */
        $customer = $this->getUserByStripeId($payload['data']['object']['customer']);

        if (is_null($customer)) {
            return new Response('No Team', 422);
        }

        return $this->teamInvoiceCreated($customer, $payload);
    }

    /**
     * Handle a successful invoice payment from a Stripe subscription.
     */
    protected function teamInvoiceCreated(Team $team, array $payload): Response
    {
        try {
            $invoiceData = $payload['data']['object'];

            // get apps/modules that this team is using
            // get items that have metered billing and their stats
            // calculate prices for each apps
            // itemize prices for each app
            $invoiceId = (!empty($invoiceData['id']) ? $invoiceData['id'] : null);

            // Add Metered Billing Items
            foreach ($invoiceData['lines']['data'] as $invoiceLineItem) {
                if (!empty($invoiceLineItem['plan']) && $invoiceLineItem['plan']['id'] === 'omnia-metered') {
                    $subscriptionId = (!empty($invoiceLineItem['id']) ? $invoiceLineItem['id'] : null);

                    dispatch(new AddMeteredBillingInvoiceItemsJob($team, $invoiceId, $subscriptionId));
                }
            }

            return new Response('Webhook Handled', 200);
        } catch (Exception $e) {
            Log::error($msg = 'Failed to handle webhook due to error: ' . $e->getMessage());

            return new Response($msg, 500);
        }
    }

    /**
     * Subscription Updated
     *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleCustomerSubscriptionUpdated(array $payload)
    {
        // Skip logic if its the omnia-metered plan
        if ($this->containsOmniaMeteredPlan($payload)) {
            return $this->successMethod();
        }

        return parent::handleCustomerSubscriptionUpdated($payload);
    }

    /**
     * Check for Omnia Metered Plan
     *
     * @return bool
     */
    public function containsOmniaMeteredPlan($payload)
    {
        if ($payload['data']['object']['plan']['id'] = 'omnia-metered') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Subscription Deleted
     *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleCustomerSubscriptionDeleted(array $payload)
    {
        // Skip logic if its the omnia-metered plan
        if ($this->containsOmniaMeteredPlan($payload)) {
            return $this->successMethod();
        }

        return parent::handleCustomerSubscriptionDeleted($payload);
    }
}
