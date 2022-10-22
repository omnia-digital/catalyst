<?php

namespace App\Support\Platform;

trait WithGuestAccess
{
    public function showAuthenticationModal(?string $redirect = null)
    {
        $this->emitTo('login-modal', 'showLoginModal', ['redirect' => $redirect]);
    }

    public function redirectToAuthenticationPage()
    {
        if (Platform::shouldShowLoginOnGuestAccess()) {
            $this->redirectRoute('login');

            return;
        }

        $this->redirectRoute('register');
    }
}
