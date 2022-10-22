<?php

namespace App\Support\Platform;

trait WithGuestAccess
{
    public function showAuthenticationModal(?string $redirect = null)
    {
        $this->emitTo('authentication-modal', 'showAuthenticationModal', ['redirect' => $redirect]);
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
