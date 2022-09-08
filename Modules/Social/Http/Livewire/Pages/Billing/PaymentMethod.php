<?php

namespace Modules\Social\Http\Livewire\Pages\Billing;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithStripe;

class PaymentMethod extends Component
{
    use WithStripe;

    public function stripeBillable()
    {
        return Auth::user();
    }

    public function render()
    {
        return view('social::livewire.pages.billing.payment-method', [
            'intent' => $this->stripeBillable()->createSetupIntent()
        ]);
    }
}
