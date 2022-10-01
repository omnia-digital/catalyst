<?php

namespace Modules\Billing\Http\Livewire\Pages\Billing\Stripe\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Billing extends Component
{
    public function getBillable()
    {
        return Auth::user();
    }

    public function render()
    {
        return view('billing::livewire.pages.billing.stripe.user.billing');
    }
}
