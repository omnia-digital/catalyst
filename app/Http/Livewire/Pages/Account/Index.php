<?php

namespace App\Http\Livewire\Pages\Account;

use Livewire\Component;

class Index extends Component
{
    public function getNavigationProperty()
    {
        return [
            []
        ];
    }

    public function render()
    {
        return view('livewire.pages.account.index');
    }
}
