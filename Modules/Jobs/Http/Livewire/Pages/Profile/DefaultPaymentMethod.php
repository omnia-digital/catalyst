<?php

namespace Modules\Jobs\Http\Livewire\Pages\Profile;

use Livewire\Component;
use Modules\Jobs\Support\Livewire\WithStripe;

class DefaultPaymentMethod extends Component
{
    use WithStripe;

    public function render()
    {
        return view('profile.default-payment-method', [
            'intent' => auth()->user()->createSetupIntent(),
        ]);
    }
}
