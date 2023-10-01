<?php

namespace App\Livewire\Partials;

use Illuminate\View\View;
use Livewire\Component;

class ProfileBadge extends Component
{
    public $user;

    protected $listeners = [
    ];

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function goToProfile()
    {
        return $this->redirect($this->user->url());
    }

    /**
     * Render the component.
     */
    public function render(): View
    {
        return view('livewire.partials.profile-badge');
    }
}
