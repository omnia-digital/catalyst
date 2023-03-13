<?php

namespace Modules\Jobs\Http\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Transaction extends Component
{
    public function render()
    {
        return view('profile.transaction', [
            'transactions' => Auth::user()->transactions()->latest()->get()
        ]);
    }
}
