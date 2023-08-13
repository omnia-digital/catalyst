<?php

namespace Modules\Livestream\Http\Livewire\Team;

use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\Livestream\Models\Team;
use Modules\Livestream\Support\Livewire\WithTimezone;

/**
 * @property array $timezones
 * @property Team $currentTeam
 */
class UpdateTimezone extends Component
{
    use WithTimezone;

    public string $timezone = '';

    public function mount()
    {
        $this->timezone = $this->currentTeam->timezone ?? '';
    }

    public function updateTimezone()
    {
        $this->validate();

        $this->currentTeam->update(['timezone' => $this->timezone]);

        $this->dispatch('saved');
    }

    public function getCurrentTeamProperty()
    {
        return auth()->user()->currentTeam;
    }

    public function render()
    {
        return view('team.update-timezone', [
            'timezones' => $this->timezones,
        ]);
    }

    protected function rules(): array
    {
        return [
            'timezone' => ['required', Rule::in($this->timezones)],
        ];
    }
}
