<?php

namespace Modules\Jobs\Http\Livewire\Pages\Profile;

use Modules\Jobs\Support\Livewire\WithStripe;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DefaultPaymentMethod extends Component
{
    use WithStripe;

    public function render()
    {
        return view('profile.default-payment-method', [
            'intent' => Auth::user()->createSetupIntent(),
        ]);
    }
}
