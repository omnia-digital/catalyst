<?php

namespace Modules\Social\Http\Livewire\Pages\Profiles;

use Livewire\Component;
use Modules\Social\Models\Profile;

class Show extends Component
{
    public $profile;

    public $additionalInfo = [
        'likes',
        'views',
        'comments',
        'volunteers',
        'members'
    ];
  
    public function getUserProperty()
    {
        return $this->profile->user;
    }

    public function mount(Profile $profile)
    {
        $this->profile = $profile->load('user');
    }

    public function render()
    {
        return view('social::livewire.pages.profiles.show');
    }
}
