<?php

namespace App\Livewire\Pages\Account;

use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Laravel\Jetstream\ConfirmsPasswords;
use Livewire\Component;

class Index extends Component
{
    use ConfirmsPasswords;

    public $email;

    public $handle;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [
        'current_password' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    /**
     * Update the user's basic account info.
     *
     * @return void
     */
    public function updateAccount()
    {
        $this->resetErrorBag();

        $validated = $this->validate($this->getAccountRules(), [
            'email.unique' => 'This email has already been taken',
            'handle.unique' => 'This username has already been taken',
        ]);

        $this->user->email = $validated['email'];
        $this->user->save();

        $this->profile->handle = $validated['handle'];
        $this->profile->save();

        $this->dispatch('account_saved');
    }

    protected function getAccountRules()
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,' . $this->user->id,
            ],
            'handle' => [
                'required',
                'string',
                'alpha_dash',
                'max:40',
                'unique:profiles,handle,' . $this->user->id,
                'unique:teams',
            ],
        ];
    }

    /**
     * Update the user's password.
     *
     * @return void
     */
    public function updatePassword(UpdatesUserPasswords $updater)
    {
        $this->resetErrorBag();

        $updater->update(auth()->user(), $this->state);

        if (request()->hasSession()) {
            request()->session()->put([
                'password_hash_' . auth()->getDefaultDriver() => auth()->user()->getAuthPassword(),
            ]);
        }

        $this->state = [
            'current_password' => '',
            'password' => '',
            'password_confirmation' => '',
        ];

        $this->dispatch('password_saved');
    }

    public function mount()
    {
        $this->email = $this->user->email;
        $this->handle = $this->profile->handle;
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return auth()->user();
    }

    public function getProfileProperty()
    {
        return $this->user->profile;
    }

    public function render()
    {
        return view('livewire.pages.account.index');
    }
}
