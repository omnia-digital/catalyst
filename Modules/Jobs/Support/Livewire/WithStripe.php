<?php namespace Modules\Jobs\Support\Livewire;

use Illuminate\Support\Facades\Auth;

trait WithStripe
{
    public $stripeToken;

    public function updatePaymentMethod()
    {
        $this->validate([
            'stripeToken' => 'required|string|regex:/^pm/',
        ]);

        Auth::user()->updateDefaultPaymentMethod($this->stripeToken);

        $this->dispatchBrowserEvent('card', [
            'card_brand'     => Auth::user()->card_brand,
            'card_last_four' => Auth::user()->card_last_four
        ]);

        $this->dispatchBrowserEvent('notify', [
            'type'    => 'success',
            'message' => 'Your payment method was updated!'
        ]);
    }
}
