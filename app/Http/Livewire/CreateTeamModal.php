<?php

namespace App\Http\Livewire;

use App\Actions\Teams\CreateTeam;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;
use Spatie\Tags\Tag;

class CreateTeamModal extends Component
{
    use WithModal, WithFileUploads;

    public ?string $name = null;

    public ?string $startDate = null;

    public ?string $summary = null;

    public $bannerImage;
    public $bannerImageName;

    public $mainImage;
    public $mainImageName;

    public $profilePhoto;
    public $profilePhotoName;

    public $sampleMedia = [];
    public $sampleMediaNames = [];

    public $teamTypes = [];

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

    public function getTeamTagsProperty()
    {
        return Tag::withType('team_type')->get()->mapWithKeys(fn(Tag $tag) => [$tag->name => ucfirst($tag->name)])->all();
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'max:254'],
            'teamTypes' => ['required', 'array'],
        ];
    }

    public function create()
    {
        $this->validate();

        $team = (new CreateTeam())->create(Auth::user(), [
            'name' => $this->name,
            'teamTypes' => $this->teamTypes,
//            'start_date' => $this->startDate,
//            'summary' => $this->summary,
//            'bannerImage' => $this->bannerImage,
//            'mainImage' => $this->mainImage,
//            'profilePhoto' => $this->profilePhoto,
//            'sampleMedia' => $this->sampleMedia,
        ]);

        $this->closeModal('create-team');
        $this->reset();

        $this->redirectRoute('social.teams.show', $team);
    }

    public function render()
    {
        return view('livewire.create-team-modal', [
            'teamTags' => $this->teamTags
        ]);
    }
}
