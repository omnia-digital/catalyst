<?php

namespace Modules\Jobs\Http\Livewire\Pages\Profile;

use Livewire\Component;

class BillingAddress extends Component
{
    public $line1;

    public $city;

    public $state;

    public $postal_code;

    public $country;

    protected $rules = [
        'line1' => 'required|string',
        'city' => 'nullable|string',
        'country' => 'nullable|string|size:2',
        'postal_code' => 'nullable|numeric',
        'state' => 'nullable|string',
    ];

    public function mount()
    {
        $customer = auth()->user()->asStripeCustomer();

        if ($customer->address) {
            $this->line1 = $customer->address->line1;
            $this->city = $customer->address->city;
            $this->country = $customer->address->country;
            $this->postal_code = $customer->address->postal_code;
            $this->state = $customer->address->state;
        }
    }

    public function updateBillingAddress()
    {
        $validated = $this->validate();

        auth()->user()->updateStripeCustomer(['address' => $validated]);

        $this->emit('saved');
    }

    public function render()
    {
        return view('profile.billing-address');
    }
}
