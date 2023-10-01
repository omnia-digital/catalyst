<?php

namespace Modules\Livestream\Jobs\Billing;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Modules\Livestream\Models\ExtraInvoiceItem;
use Modules\Livestream\Models\Team;
use Modules\Livestream\Services\Mux\MuxDeliveryUsage;
use Stripe\InvoiceItem;
use Stripe\Stripe;

class AddMeteredBillingInvoiceItemsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private Team $team,
        private string $invoiceId,
        private string $subscriptionId
    ) {
    }

    public function handle()
    {
        $context = $this->team->name;
        $context .= '. Invoice: ' . $this->invoiceId;
        $context .= '. Subscription: ' . $this->subscriptionId;

        Log::info('Attempting to add Metered Billing Invoice Items for ' . $context);

        $invoiceItems = $this->addMeteredBillingInvoiceItems();

        Log::info('Finished adding Metered Billing Invoice Items for ' . $context);

        return $invoiceItems;
    }

    private function addMeteredBillingInvoiceItems()
    {
        Log::info(__FUNCTION__ . ': START');

        $livestreamAccount = $this->team->livestreamAccount;

        // Get the delivery usages of the given livestream account.
        $deliveryUsages = app(MuxDeliveryUsage::class)->getDeliveryUsageForInvoice($livestreamAccount);

        // Get the extra invoice items of deleted episodes in the CURRENT MONTH.
        $extraInvoiceItems = $this->getExtraInvoiceItemsForDeletedEpisodes();

        // (encoding) Calculate the asset duration seconds
        $encodingSeconds = $deliveryUsages->sum('asset_duration');

        // (storage) Calculate sum of durations of all billable episodes for this account (divide by 1000 since it's stored as milliseconds)
        $storageSeconds = $livestreamAccount->episodes()->expired()->sum('duration') / 1000;

        // (streamed/delivered) Calculate the delivered seconds
        $deliveredSeconds = $deliveryUsages->sum('delivered_seconds');

        // Calculate the cost based on duration (seconds) and metered price.
        // Storage cost is always a sum of normal storage cost + deleted episode storage cost.
        $encodingCost = round($encodingSeconds * $this->getMeteredPrice('encoding'), 2);
        $storageCost = round($storageSeconds * $this->getMeteredPrice('storage'),
            2) + $extraInvoiceItems->sum('amount');
        $deliveredCost = round($deliveredSeconds * $this->getMeteredPrice('delivered'), 2);

        Log::info('Encoding: ' . $encodingCost);
        Log::info('Storage (Included deleted episodes): ' . $storageCost);
        Log::info('Delivered: ' . $deliveredCost);

        $invoiceItem = $this->createStripeInvoiceItem(
            $this->team->stripeId(),
            $encodingCost + $storageCost + $deliveredCost,
            "Encoding usage cost is {$encodingCost} USD. Storage usage cost is {$storageCost}. Delivered usage cost is {$deliveredCost} USD.",
            $this->invoiceId
        );

        // Finally, update the extra invoice item.
        $extraInvoiceItems->each(function (ExtraInvoiceItem $extraInvoiceItem) {
            $extraInvoiceItem->update(['added_to_invoice_at' => now()]);
        });

        Log::info(__FUNCTION__ . ': END');

        return $invoiceItem;
    }

    /**
     * Get the extra invoice items of the current month.
     */
    private function getExtraInvoiceItemsForDeletedEpisodes(): Collection
    {
        return $this->team->extraInvoiceItems()
            ->currentMonth()
            ->get();
    }

    /**
     * Get metered price based on the current plan of team.
     */
    private function getMeteredPrice(string $metered): int|float
    {
        return config('metered.price.unit') === 'minute'
            ? $this->team->meteredPrice($metered) / 60
            : $this->team->meteredPrice($metered);
    }

    private function createStripeInvoiceItem(
        string $customerId,
        float $amount,
        string $description,
        ?string $invoiceId = null
    ) {
        // Invoice item information.
        $params = [
            'customer' => $customerId,
            'amount' => round($amount, 2) * 100,
            'description' => $description,
            'currency' => 'usd',
        ];

        // If the Invoice Id exists, add it as the invoice to add these items to
        empty($invoiceId) || $params['invoice'] = $invoiceId;

        // Add Invoice Item
        Stripe::setApiKey(config('services.stripe.secret'));

        return InvoiceItem::create($params);
    }
}
