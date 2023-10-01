<?php

namespace Modules\Billing\Traits;

use Modules\Billing\Models\ChargentSubscription;

trait WithChargentSubscriptions
{
    public function chargentSubscription()
    {
        if (! class_exists(ChargentSubscription::class)) {
            return;
        }

        return $this->hasOne(ChargentSubscription::class);
    }
}
