<?php

namespace Modules\Payments\Http\Livewire\Pages\Billing;

use Livewire\Component;

class Invoices extends Component
{
    public function render()
    {
        return view('payments::livewire.pages.billing.invoices', [
            'invoices' => auth()->user()->invoicesIncludingPending()
        ]);
    }
}
