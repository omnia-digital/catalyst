<?php

namespace Modules\Billing\Http\Livewire\Pages\Billing\Stripe\User;

use Livewire\Component;

class Invoices extends Component
{
    public function render()
    {
        return view('billing::livewire.pages.billing.stripe.user.invoices', [
            'invoices' => auth()->user()->invoicesIncludingPending()
        ]);
    }
}
