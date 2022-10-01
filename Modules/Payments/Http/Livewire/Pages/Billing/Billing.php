<?php

namespace Modules\Payments\Http\Livewire\Pages\Billing;

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
        return view('payments::livewire.pages.billing.billing');
    }
}
