<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;

class LoginModal extends Component
{
    use WithModal;

    public ?string $redirectAfterLogin = null;

    public ?string $email = null;

    public ?string $password = null;

    public bool $remember = false;

    protected $listeners = [
        'showLoginModal' => 'handleShowLoginModal'
    ];

    protected function rules(): array
    {
        return [
            'email' => ['required'],
            'password' => ['required'],
        ];
    }

    public function handleShowLoginModal($data)
    {
        $this->redirectAfterLogin = $data['redirect'] ?? route('social.home');

        $this->openModal('login-modal');
    }

    public function login()
    {
        $this->validate();

        $this->guard()->attempt(
            ['email' => $this->email, 'password' => $this->password], $this->remember
        );

        $this->redirect($this->redirectAfterLogin);
    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function render()
    {
        return view('livewire.login-modal');
    }
}
