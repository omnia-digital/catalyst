<?php

namespace Modules\Social\Http\Livewire\Pages\Projects;

use App\Models\Team;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use OmniaDigital\OmniaLibrary\Livewire\WithPlace;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Edit extends Component
{
    use WithPlace, AuthorizesRequests, WithFileUploads;

    public Team $team;

    public $selected;

    public array $newAddress = [];

    public bool $removeAddress = false;

    public $bannerImage;
    public $bannerImageName;

    public $mainImage;
    public $mainImageName;

    public $sampleMedia = [];
    public $sampleMediaNames = [];

    public $confirmingRemoveMedia = false;
    public $mediaToRemove;

    protected function rules(): array
    {
        return [
            'team.name' => ['required', 'max:254'],
            'team.start_date' => ['required', 'date'],
            'team.summary' => ['required', 'max:280'],
            'team.content' => ['required', 'max:65500'],
        ];
    }

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

    public function updatedSampleMedia()
    {
        $this->validate([
            'sampleMedia.*' => 'image',
        ]);

        foreach ($this->sampleMedia as $key => $media) {
            $this->sampleMediaNames[$key] = $media->getClientOriginalName();
        }
    }

    public function mount(Team $team)
    {
        $this->authorize('update-team', $team);
        $this->team = $team->load('owner');
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
        
        $this->removeAddress && $this->team->teamLocation()->delete();

        if(!empty($this->newAddress)) {
            $this->team->teamLocation()->updateOrCreate(
                ['team_id' => $this->team->id],
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
        
        if (sizeof($this->sampleMedia)) {
            foreach ($this->sampleMedia as $media) {
                $this->team->addMedia($media)->toMediaCollection('team_sample_images');
            }
        }

        $this->emit('changes_saved');

        $this->team->refresh();

        $this->reset('newAddress', 'removeAddress', 'bannerImage', 'bannerImageName', 'mainImage', 'mainImageName', 'sampleMedia', 'sampleMediaNames');
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
        return view('social::livewire.pages.projects.edit');
    }
}
