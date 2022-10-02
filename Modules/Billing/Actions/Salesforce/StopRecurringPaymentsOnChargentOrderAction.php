<?php namespace Modules\Billing\Actions\Salesforce;

use Carbon\Carbon;
use Modules\Billing\Models\ChargentSubscription;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;

class StopRecurringPaymentsOnChargentOrderAction
{
    /**
     * @param ChargentSubscription $subscription
     */
    public function execute(ChargentSubscription $subscription)
    {
        if (!$subscription->chargent_order_id) {
            return null;
        }

        Forrest::authenticate();

        Forrest::sobjects("ChargentOrders__ChargentOrder__c/{$subscription->chargent_order_id}", [
            'method' => 'patch',
            'body' => [
                'ChargentOrders__Payment_Status__c'     => 'Stopped',
                'ChargentOrders__Payment_Stop__c'       => 'Date',
                'ChargentOrders__Payment_End_Date__c'   => now(),
            ]
        ]);

        $subscription->update([
            'status'                => 'Stopped',
            'ends_at'               => now(),
        ]);
    }
}
