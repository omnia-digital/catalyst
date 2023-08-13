<?php

namespace Modules\Livestream\Http\Livewire\Profile;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\Livestream\Models\User;
use Modules\Livestream\Support\Livewire\WithTimezone;

/**
 * @property array $timezones
 * @property Authenticatable|User $currentUser
 */
class UpdateTimezone extends Component
{
    use WithTimezone;

    public ?string $timezone = null;

    public function mount()
    {
        $this->timezone = $this->currentUser->timezone;
    }

    public function updateTimezone()
    {
        $this->validate();

        $this->currentUser->update(['timezone' => $this->timezone]);

        $this->dispatch('saved');
    }

    public function getCurrentUserProperty()
    {
        return auth()->user();
    }

    public function render()
    {
        return view('profile.update-timezone', [
            'timezones' => $this->timezones,
        ]);
    }

    protected function rules(): array
    {
        return [
            'timezone' => ['nullable', Rule::in($this->timezones)],
        ];
    }
}
