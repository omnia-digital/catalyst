<?php namespace Modules\Subscriptions\Traits;

use Modules\Subscriptions\Models\ChargentSubscription;

trait WithChargentSubscriptions
{
    public function chargentSubscription() {
        if (!class_exists(ChargentSubscription::class)) return;
        return $this->hasOne(ChargentSubscription::class);
    }
}