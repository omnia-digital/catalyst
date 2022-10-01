<?php namespace Modules\Payments\Traits;

use Modules\Payments\Models\ChargentSubscription;

trait WithChargentSubscriptions
{
    public function chargentSubscription() {
        if (!class_exists(ChargentSubscription::class)) return;
        return $this->hasOne(ChargentSubscription::class);
    }
}
