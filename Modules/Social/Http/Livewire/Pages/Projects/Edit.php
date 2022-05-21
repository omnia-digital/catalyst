<?php

namespace Modules\Social\Http\Livewire\Pages\Projects;

use App\Models\Team;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithPlace;

class Edit extends Component
{
    use WithPlace;

    public Team $team;

    public $selected;

    public array $newAddress = [];

    public bool $removeAddress = false;

    protected function rules(): array
    {
        return [
            'team.name' => ['required', 'max:254'],
            'team.start_date' => ['required', 'date'],
            'team.summary' => ['required', 'max:280'],
            'team.target_audience' => ['required', 'max:254'],
            'team.content' => ['required', 'max:65500'],
        ];
    }

    public function mount(Team $team)
    {
        $this->team = $team->load('owner');
    }

    public function setAddress()
    {
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

        $this->emit('changes_saved');

        $this->team->refresh();

        $this->reset('newAddress', 'removeAddress');
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

    public function render()
    {
        return view('social::livewire.pages.teams.edit');
    }
}
