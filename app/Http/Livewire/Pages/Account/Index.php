<?php

namespace App\Http\Livewire\Pages\Account;

use Auth;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Laravel\Jetstream\ConfirmsPasswords;
use Livewire\Component;
use Modules\Social\Models\Profile;

class Index extends Component
{
    use ConfirmsPasswords;

    public $email;

    public $handle;

    protected function getAccountRules() {
        return [
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                'unique:users,email,'.$this->user->id
            ],
            'handle' => [
                'required', 
                'string', 
                'alpha_dash', 
                'max:40', 
                'unique:profiles,handle,'.$this->user->id,
                'unique:teams',
            ]
        ];
    } 

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

        $this->emit('account_saved');
    }

    /**
     * Update the user's password.
     *
     * @param  \Laravel\Fortify\Contracts\UpdatesUserPasswords  $updater
     * @return void
     */
    public function updatePassword(UpdatesUserPasswords $updater)
    {
        $this->resetErrorBag();

        $updater->update(Auth::user(), $this->state);

        if (request()->hasSession()) {
            request()->session()->put([
                'password_hash_'.Auth::getDefaultDriver() => Auth::user()->getAuthPassword(),
            ]);
        }

        $this->state = [
            'current_password' => '',
            'password' => '',
            'password_confirmation' => '',
        ];

        $this->emit('password_saved');
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
        return Auth::user();
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
