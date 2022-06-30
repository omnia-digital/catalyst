<?php

namespace Modules\Social\Http\Livewire\Pages\Profiles;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Social\Models\Profile;

class Edit extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public Profile $profile;

    public $bannerImage;
    public $bannerImageName;

    public $photo;
    public $photoName;

    protected function rules(): array
    {
        return [
            'profile.first_name' => ['required', 'max:254'],
            'profile.last_name' => ['required', 'max:254'],
            'profile.bio' => ['required', 'max:280'],
        ];
    }

    public function updatedBannerImage()
    {
        $this->validate([
            'bannerImage' => 'image',
        ]);

        $this->bannerImageName = $this->bannerImage->getClientOriginalName();
    }

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image',
        ]);

        $this->photoName = $this->photo->getClientOriginalName();
    }

    public function getUserProperty()
    {
        return $this->profile->user;
    }

    public function mount(Profile $profile)
    {
        $this->authorize('update-profile', $profile);
        $this->profile = $profile->load('user');
    }
    
    public function saveChanges()
    {
        $this->validate();
        
        $this->profile->save();

        if(!is_null($this->bannerImage) && $this->profile->bannerImage()->count()) {
            $this->profile->bannerImage()->delete();
        }
        $this->bannerImage &&
            $this->profile->addMedia($this->bannerImage)->toMediaCollection('profile_banner_images');

        if($this->photo && $this->profile->photo()->count()) {
            $this->profile->photo()->delete();
        }
        $this->photo &&
            $this->profile->addMedia($this->photo)->toMediaCollection('profile_photos');

        $this->emit('changes_saved');

        $this->profile->refresh();
        $this->reset('bannerImage', 'bannerImageName', 'photo', 'photoName');
    }

    public function render()
    {
        return view('social::livewire.pages.profiles.edit');
    }
}
