<?php

namespace Modules\Billing\Http\Livewire\Pages\Billing\Stripe\User;

use Livewire\Component;

class Billing extends Component
{
    public function getBillable()
    {
        return auth()->user();
    }

    public function render()
    {
        return view('billing::livewire.pages.billing.stripe.user.billing');
    }
}
