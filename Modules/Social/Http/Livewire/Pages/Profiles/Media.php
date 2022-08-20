<?php

namespace Modules\Social\Http\Livewire\Pages\Profiles;

use Livewire\Component;
use Modules\Social\Models\Profile;

class Media extends Component
{
    public $profile; 
    public $media;

    public function getUserProperty()
    {
        return $this->profile->user;
    }

    public function mount(Profile $profile): void
    {
        $this->profile = $profile->load('user');
        $this->media = $this->user->postMedia;
    }

    public function render(): \Illuminate\View\View
    {
        return view('social::livewire.pages.profiles.media');
    }
}
