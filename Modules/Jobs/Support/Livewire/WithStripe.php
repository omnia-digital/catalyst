<?php

namespace Modules\Jobs\Support\Livewire;

trait WithStripe
{
    public $stripeToken;

    public function updatePaymentMethod()
    {
        $this->validate([
            'stripeToken' => 'required|string|regex:/^pm/',
        ]);

        auth()->user()->updateDefaultPaymentMethod($this->stripeToken);

        $this->dispatch('card', [
            'card_brand' => auth()->user()->card_brand,
            'card_last_four' => auth()->user()->card_last_four,
        ]);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Your payment method was updated!',
        ]);
    }
}
