<?php

namespace App\Support\Platform;

trait WithGuestAccess
{
    public function showAuthenticationModal(?string $redirect = null)
    {
        $this->dispatch('showAuthenticationModal', redirect: $redirect)->to('authentication-modal');
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
