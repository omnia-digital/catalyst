<?php

namespace Modules\Social\Http\Livewire\Pages\Billing;

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
        return view('social::livewire.pages.billing.billing');
    }
}
