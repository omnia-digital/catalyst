<?php

namespace Modules\Social\Http\Livewire\Pages\Profiles;

use App\Models\Tag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Social\Models\Profile;
use Squire\Models\Country;

class Edit extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public Profile $profile;

    public ?string $country = null;

    public $bannerImage;
    public $bannerImageName;

    public $photo;
    public $photoName;

    public $profileTypes = [];

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

    public function getProfileTagsProperty()
    {
        return Tag::withType('profile_type')->get()->mapWithKeys(fn (Tag $tag) => [$tag->name => ucwords($tag->name)])->all();
    }

    public function mount(Profile $profile)
    {
        $this->authorize('update-profile', $profile);
        $this->profile = $profile->load('user');
        $this->country = $profile->country ?? array_keys($this->countriesArray())[0];
    }

    public function saveChanges()
    {
        $this->validate();

        $this->profile->country = $this->country;
        $this->profile->save();

        if (! empty($this->profileTypes)) {
            $this->profile->attachTags($this->profileTypes, 'profile_type');
        }

        if (! is_null($this->bannerImage) && $this->profile->bannerImage()->count()) {
            $this->profile->bannerImage()->delete();
        }
        $this->bannerImage &&
            $this->profile->addMedia($this->bannerImage)->toMediaCollection('profile_banner_images');

        if ($this->photo && $this->profile->photo()->count()) {
            $this->profile->photo()->delete();
        }
        $this->photo &&
            $this->profile->addMedia($this->photo)->toMediaCollection('profile_photos');

        $this->emit('changes_saved');

        $this->profile->refresh();
        $this->reset('bannerImage', 'bannerImageName', 'photo', 'photoName');
    }

    public function removeTag(string $tagName)
    {
        $this->profile->detachTag(Tag::findFromString($tagName, 'profile_type'));
        $this->profile->refresh();
    }

    public function countriesArray()
    {
        return Country::orderBy('name')->pluck('name', 'code_3')->toArray();
    }

    public function render()
    {
        return view('social::livewire.pages.profiles.edit', [
            'countries' => $this->countriesArray(),
            'profileTags' => $this->profileTags,
        ]);
    }

    protected function rules(): array
    {
        return [
            'profile.first_name' => ['required', 'max:254'],
            'profile.last_name' => ['required', 'max:254'],
            'profile.bio' => ['max:280'],
            'profile.website' => ['max:280'],
            'profile.birth_date' => ['required', 'date'],
            'country' => ['required', Rule::in(Country::select('code_3')->pluck('code_3')->toArray())],
            'profileTypes' => ['nullable', 'array'],
        ];
    }
}
