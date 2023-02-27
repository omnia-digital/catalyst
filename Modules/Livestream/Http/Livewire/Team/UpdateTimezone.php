<?php namespace App\Http\Livewire\Team;

use App\Models\Team;
use App\Support\Livewire\WithTimezone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

/**
 * @property array $timezones
 * @property Team $currentTeam
 */
class UpdateTimezone extends Component
{
    use WithTimezone;

    public string $timezone = '';

    protected function rules(): array
    {
        return [
            'timezone' => ['required', Rule::in($this->timezones)]
        ];
    }

    public function mount()
    {
        $this->timezone = $this->currentTeam->timezone ?? '';
    }

    public function updateTimezone()
    {
        $this->validate();

        $this->currentTeam->update(['timezone' => $this->timezone]);

        $this->emit('saved');
    }

    public function getCurrentTeamProperty()
    {
        return Auth::user()->currentTeam;
    }

    public function render()
    {
        return view('team.update-timezone', [
            'timezones' => $this->timezones
        ]);
    }
}
