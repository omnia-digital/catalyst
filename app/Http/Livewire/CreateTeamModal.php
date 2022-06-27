<?php

namespace App\Http\Livewire;

use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;

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

    public $sampleMedia = [];
    public $sampleMediaNames = [];

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

    protected function rules(): array
    {
        return [
            'name' => ['required', 'max:254'],
            'startDate' => ['required', 'date'],
            'summary' => ['required', 'max:280'],
        ];
    }

    public function create()
    {
        $this->validate();

        /** @var Team $team */
        $team = Auth::user()->ownedTeams()->create([
            'name' => $this->name,
            'start_date' => $this->startDate,
            'summary' => $this->summary,
            'personal_team' => false,
        ]);

        $team->addMedia($this->bannerImage)->toMediaCollection('team_banner_images');
        $team->addMedia($this->mainImage)->toMediaCollection('team_main_images');
        
        foreach ($this->sampleMedia as $media) {
            $team->addMedia($media)->toMediaCollection('team_sample_images');
        }

        Auth::user()->switchTeam($team);

        $this->closeModal('create-team');
        $this->reset();

        $this->redirectRoute('social.projects.show', $team);
    }

    public function render()
    {
        return view('livewire.create-team-modal');
    }
}
