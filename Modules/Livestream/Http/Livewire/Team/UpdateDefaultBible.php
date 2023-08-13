<?php

namespace Modules\Livestream\Http\Livewire\Team;

use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\Livestream\Models\Team;
use Modules\Livestream\Omnia;

/**
 * @property array $bibleOptions
 * @property Team $currentTeam
 */
class UpdateDefaultBible extends Component
{
    public ?string $defaultBible = null;

    public function mount()
    {
        $this->defaultBible = $this->currentTeam->default_bible;
    }

    public function updateDefaultBible()
    {
        $this->validate();

        $this->currentTeam->update(['default_bible' => $this->defaultBible]);

        $this->dispatch('saved');
    }

    public function getBibleOptionsProperty()
    {
        return collect(Omnia::bibleOptions())->pluck('title', 'code')->all();
    }

    public function getCurrentTeamProperty()
    {
        return auth()->user()->currentTeam;
    }

    public function render()
    {
        return view('team.update-default-bible', [
            'bibleOptions' => $this->bibleOptions,
        ]);
    }

    protected function rules(): array
    {
        return [
            'defaultBible' => ['nullable', Rule::in(array_keys($this->bibleOptions))],
        ];
    }
}
