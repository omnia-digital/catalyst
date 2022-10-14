<?php

namespace Modules\Social\Http\Livewire\Pages\Teams\Admin;

use App\Models\Team;
use App\Support\Platform\Platform;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;
use OmniaDigital\OmniaLibrary\Livewire\WithPlace;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Trans;

class TeamAdmin extends Component/*  implements HasForms */
{
    use WithPlace, AuthorizesRequests, WithFileUploads, WithNotification/* , InteractsWithForms */;

    public Team $team;

    public $selected;

    public array $newAddress = [];

    public bool $removeAddress = false;

    public $bannerImage;
    public $bannerImageName;

    public $mainImage;
    public $mainImageName;

    public $profilePhoto;
    public $profilePhotoName;

    public $sampleMedia = [];
    public $sampleMediaNames = [];

    public $confirmingRemoveMedia = false;
    public $mediaToRemove;
    public $applicationsCount = 0;

    public function mount(Team $team)
    {
        $this->authorize('update-team', $team);
        $this->team = $team->load('owner');
        $this->applicationsCount = $this->team->teamApplications->count();
    }

    protected function rules(): array
    {
        $rules = [
            'team.name' => ['required', 'max:254'],
            'team.start_date' => ['date'],
            'team.end_date' => ['date', 'after_or_equal:team.start_date'],
            'team.summary' => ['max:280'],
            'team.content' => ['max:65500'],
        ];

//        if (Platform::hasGeneralSettingEnabled('team_require_start_date')) {
//            $rules['team.start_date'] = ['required', 'date'];
//        } else {
//            $rules['team.start_date'] = ['date'];
//        }

        if (\Platform::isModuleEnabled('games')) {
//            $rules['team.youtube_channel_id'] = ['max:65500'];
//            $rules['team.twitch_channel_id'] = ['max:65500'];
        }

        return $rules;
    }

/*     protected function getFormSchema(): array
    {
        return [
            TextInput::make('team.name')->required(),
            DatePicker::make('team.start_date')->required(),
            Textarea::make('team.summary')->required(),
            MarkdownEditor::make('team.content')->required(),
        ];
    } */

    public function updatedBannerImage()
    {
        $this->validate([
            'bannerImage' => 'image',
        ]);

        $this->bannerImageName = $this->bannerImage->getClientOriginalName();
    }

    public function updatedMainImage()
    {
        $this->validate([
            'mainImage' => 'image',
        ]);

        $this->mainImageName = $this->mainImage->getClientOriginalName();
    }

    public function updatedProfilePhoto()
    {
        $this->validate([
            'profilePhoto' => 'image',
        ]);

        $this->profilePhotoName = $this->profilePhoto->getClientOriginalName();
    }

    public function updatedSampleMedia()
    {
        $this->validate([
            'sampleMedia.*' => 'image',
        ]);

        foreach ($this->sampleMedia as $key => $media) {
            $this->sampleMediaNames[$key] = $media->getClientOriginalName();
        }
    }

    public function setAddress()
    {
        if(is_null($this->placeId)) {
            return;
        }
        $place = $this->findPlace();
        $this->newAddress = [
            'address'          => $place->address(),
            'address_line_2'   => $place->addressLine2(),
            'city'             => $place->city(),
            'state'            => $place->state(),
            'postal_code'      => $place->postalCode(),
            'country'          => $place->country()
        ];

    }

    public function saveChanges()
    {
        $this->validate();

        $this->team->save();

        $this->removeAddress && $this->team->location()->delete();

        if(!empty($this->newAddress)) {
            $this->team->location()->updateOrCreate(
                ['model_id' => $this->team->id, 'model_type' => Team::class],
                $this->newAddress
            );
        }

        if(!is_null($this->bannerImage) && $this->team->bannerImage()->count()) {
            $this->team->bannerImage()->delete();
        }
        $this->bannerImage &&
            $this->team->addMedia($this->bannerImage)->toMediaCollection('team_banner_images');

        if($this->mainImage && $this->team->mainImage()->count()) {
            $this->team->mainImage()->delete();
        }
        $this->mainImage &&
            $this->team->addMedia($this->mainImage)->toMediaCollection('team_main_images');

        if($this->profilePhoto && $this->team->profilePhoto()->count()) {
            $this->team->profilePhoto()->delete();
        }
        $this->profilePhoto &&
            $this->team->addMedia($this->profilePhoto)->toMediaCollection('team_profile_photos');

        if (sizeof($this->sampleMedia)) {
            foreach ($this->sampleMedia as $media) {
                $this->team->addMedia($media)->toMediaCollection('team_sample_images');
            }
        }

        $this->success(Trans::get('Team Information Saved'));
        $this->emit('changes_saved');

        $this->team->refresh();

        $this->reset('newAddress', 'removeAddress', 'bannerImage', 'bannerImageName', 'profilePhoto', 'profilePhotoName', 'mainImage', 'mainImageName', 'sampleMedia', 'sampleMediaNames');
    }

    public function confirmRemoval(Media $media)
    {
        $this->confirmingRemoveMedia = true;
        $this->mediaToRemove = $media;
    }
    public function removeMedia()
    {
        $this->mediaToRemove->delete();
        $this->confirmingRemoveMedia = false;
        $this->team->refresh();
        $this->reset('mediaToRemove');
    }

    public function removeNewMedia($key)
    {
        unset($this->sampleMedia[$key]);
        unset($this->sampleMediaNames[$key]);
    }

    public function getSelectedAddressProperty()
    {
        $address = '';
        $address .= $this->newAddress['address'];

        if ($this->newAddress['address_line_2']) {
            $address .= " " . $this->newAddress['address_line_2'];
        }

        $address .= ", " . $this->newAddress['city'] . ', ' . $this->newAddress['state'] . ', ' . $this->newAddress['postal_code'] . " " . $this->newAddress['country'];

        return $address;
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    public function render()
    {
        return view('social::livewire.pages.teams.admin.team-admin');
    }
}
