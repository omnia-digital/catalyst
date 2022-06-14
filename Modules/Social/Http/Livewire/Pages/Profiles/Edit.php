<?php

namespace Modules\Social\Http\Livewire\Pages\Profiles;

use Livewire\Component;
use Modules\Social\Models\Profile;

class Edit extends Component
{
    public Profile $profile;

    protected function rules(): array
    {
        return [
            'profile.first_name' => ['required', 'max:254'],
            'profile.last_name' => ['required', 'max:254'],
            'profile.bio' => ['required', 'max:280'],
        ];
    }

    public function getUserProperty()
    {
        return $this->profile->user;
    }

    public function mount(Profile $profile)
    {
        $this->profile = $profile->load('user');
    }
    
    public function saveChanges()
    {
        $this->validate();
        
        $this->profile->save();

        $this->emit('changes_saved');

        $this->profile->refresh();
    }

    public function render()
    {
        return view('social::livewire.pages.profiles.edit');
    }
}
