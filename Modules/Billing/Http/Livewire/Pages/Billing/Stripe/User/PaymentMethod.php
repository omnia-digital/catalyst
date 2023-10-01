<?php

namespace Modules\Billing\Http\Livewire\Pages\Billing\Stripe\User;

use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithStripe;

class PaymentMethod extends Component
{
    use WithStripe;

    public function render()
    {
        return view('billing::livewire.pages.billing.stripe.user.payment-method', [
            'intent' => $this->stripeBillable()->createSetupIntent(),
        ]);
    }

    public function stripeBillable()
    {
        $user = auth()->user();
        $user->createOrGetStripeCustomer();

        return $user;
    }
}
