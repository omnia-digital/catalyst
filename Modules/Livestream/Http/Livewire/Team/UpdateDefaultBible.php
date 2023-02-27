<?php

namespace App\Http\Livewire\Team;

use App\Models\Team;
use App\Omnia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

/**
 * @property array $bibleOptions
 * @property Team $currentTeam
 */
class UpdateDefaultBible extends Component
{
    public ?string $defaultBible = null;

    protected function rules(): array
    {
        return [
            'defaultBible' => ['nullable', Rule::in(array_keys($this->bibleOptions))]
        ];
    }

    public function mount()
    {
        $this->defaultBible = $this->currentTeam->default_bible;
    }

    public function updateDefaultBible()
    {
        $this->validate();

        $this->currentTeam->update(['default_bible' => $this->defaultBible]);

        $this->emit('saved');
    }

    public function getBibleOptionsProperty()
    {
        return collect(Omnia::bibleOptions())->pluck('title', 'code')->all();
    }

    public function getCurrentTeamProperty()
    {
        return Auth::user()->currentTeam;
    }

    public function render()
    {
        return view('team.update-default-bible', [
            'bibleOptions' => $this->bibleOptions
        ]);
    }
}
