<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Support\Platform\Platform;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;

class AuthenticationModal extends Component
{
    use WithModal;

    public ?string $redirectAfterLogin = null;

    public ?string $firstName = null;

    public ?string $lastName = null;

    public ?string $email = null;

    public ?string $password = null;

    public ?string $password_confirmation = null;

    public bool $remember = false;

    public bool $showLoginModal = false;

    protected $listeners = [
        'showAuthenticationModal' => 'handleShowAuthenticationModal'
    ];

    protected function rules(): array
    {
        if ($this->showLoginModal) {
            return [
                'email' => ['required'],
                'password' => ['required'],
            ];
        }

        return [
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', new Password, 'confirmed'],
        ];
    }

    public function mount()
    {
        $this->showLoginModal = Platform::shouldShowLoginOnGuestAccess();
    }

    public function handleShowAuthenticationModal($data)
    {
        $this->redirectAfterLogin = $data['redirect'] ?? route('social.home');

        $this->openModal('authentication-modal');
    }

    public function login()
    {
        $this->validate();

        $this->guard()->attempt(
            ['email' => $this->email, 'password' => $this->password], $this->remember
        );

        $this->redirect($this->redirectAfterLogin);
    }

    public function register()
    {
        $this->validate();

        $user = DB::transaction(function () {
            return tap(User::create([
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]), function (User $user) {
                $this->createProfile($user);
            });
        });

        $this->guard()->login($user);

        $this->redirect($this->redirectAfterLogin);
    }

    protected function createProfile(User $user)
    {
        $user->profile()->create([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
        ]);
    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function render()
    {
        return view('livewire.authentication-modal');
    }
}
