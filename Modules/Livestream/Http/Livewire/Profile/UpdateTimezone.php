<?php namespace Modules\Livestream\Http\Livewire\Profile;

use Modules\Livestream\Models\User;
use Modules\Livestream\Support\Livewire\WithTimezone;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

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

    protected function rules(): array
    {
        return [
            'timezone' => ['nullable', Rule::in($this->timezones)]
        ];
    }

    public function updateTimezone()
    {
        $this->validate();

        $this->currentUser->update(['timezone' => $this->timezone]);

        $this->emit('saved');
    }

    public function getCurrentUserProperty()
    {
        return Auth::user();
    }

    public function render()
    {
        return view('profile.update-timezone', [
            'timezones' => $this->timezones
        ]);
    }
}
