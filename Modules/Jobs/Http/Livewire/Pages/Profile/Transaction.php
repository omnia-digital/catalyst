<?php

namespace Modules\Jobs\Http\Livewire\Pages\Profile;

use Livewire\Component;

class Transaction extends Component
{
    public function render()
    {
        return view('profile.transaction', [
            'transactions' => auth()->user()->transactions()->latest()->get(),
        ]);
    }
}
