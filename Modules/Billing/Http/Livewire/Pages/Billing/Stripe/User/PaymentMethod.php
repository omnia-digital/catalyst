<?php

namespace Modules\Billing\Http\Livewire\Pages\Billing\Stripe\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithStripe;

class PaymentMethod extends Component
{
    use WithStripe;

    public function stripeBillable()
    {
        $user = Auth::user();
        $user->createOrGetStripeCustomer();
        return $user;
    }

    public function render()
    {
        return view('billing::livewire.pages.billing.stripe.user.payment-method', [
            'intent' => $this->stripeBillable()->createSetupIntent()
        ]);
    }
}
