<?php namespace Modules\Subscriptions\Actions\Salesforce;

use Carbon\Carbon;
use Modules\Subscriptions\Models\ChargentSubscription;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;

class GetChargentOrderInfoAction
{
    /**
     * @param ChargentSubscription $subscription
     */
    public function execute(ChargentSubscription $subscription)
    {
        if (!$subscription?->chargent_order_id || !config('forrest.credentials.consumerKey')) {
            return null;
        }

        Forrest::authenticate();
        $chargentOrder = Forrest::query(
            "SELECT Id, 
            ChargentOrders__Last_Transaction__c, 
            ChargentOrders__Next_Transaction_Date__c,
            ChargentOrders__Payment_Status__c,
            ChargentOrders__Payment_Start_Date__c,
            ChargentOrders__Payment_End_Date__c FROM ChargentOrders__ChargentOrder__c 
            WHERE Id = '" . $subscription->chargent_order_id . "'"
        );

        $subscription->update([
            'last_transaction_at'   => Carbon::parse($chargentOrder['records'][0]['ChargentOrders__Last_Transaction__c']),
            'next_invoice_at'       => Carbon::parse($chargentOrder['records'][0]['ChargentOrders__Next_Transaction_Date__c']),
            'starts_at'             => Carbon::parse($chargentOrder['records'][0]['ChargentOrders__Payment_Start_Date__c']),
            'ends_at'               => $chargentOrder['records'][0]['ChargentOrders__Payment_End_Date__c']
                                        ? Carbon::parse($chargentOrder['records'][0]['ChargentOrders__Payment_End_Date__c'])
                                        : null,
            'status'                => $chargentOrder['records'][0]['ChargentOrders__Payment_Status__c'],
        ]);
    }
}
