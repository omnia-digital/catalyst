<?php

namespace Modules\Subscriptions\Http\Livewire\Pages\Billing;

use Livewire\Component;

class Invoices extends Component
{
    public function render()
    {
        return view('social::livewire.pages.billing.invoices', [
            'invoices' => auth()->user()->invoicesIncludingPending()
        ]);
    }
}
