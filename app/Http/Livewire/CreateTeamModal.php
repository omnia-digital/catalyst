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




    /**
     * @var array
     */
      /**
     * @var array
     */
    public array $teamTypes = [];

    public function create(): void
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
}
