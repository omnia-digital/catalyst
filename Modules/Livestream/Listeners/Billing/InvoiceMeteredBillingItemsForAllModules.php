<?php

namespace App\Listeners\Billing;


use Illuminate\Support\Facades\Bus;
use App\Jobs\Billing\AddLivestreamMeteredBillingInvoiceItems;

class InvoiceMeteredBillingItemsForAllModules
{

	/**
	 * Handle the event.
	 *
	 * @param $event
	 */
    public function handle($event)
    {
        // Livestream
        // todo: we should probably dispatch all billing jobs onto their own queue with only 1 try to avoid billing errors
        dispatch(new AddLivestreamMeteredBillingInvoiceItems($event->team, $event->invoiceId, $event->subscriptionId));
    }
}
