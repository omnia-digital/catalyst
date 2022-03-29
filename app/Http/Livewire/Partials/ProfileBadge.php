<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;

class ProfileBadge extends Component
{
    public $user;

    protected $listeners = [
    ];

    public function mount()
    {
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render(): \Illuminate\View\View
    {
        return view('livewire.partials.profile-badge');
    }
}
