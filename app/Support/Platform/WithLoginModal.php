<?php

namespace App\Support\Platform;

trait WithLoginModal
{
    public function showLoginModal(?string $redirect = null)
    {
        $this->emitTo('login-modal', 'showLoginModal', ['redirect' => $redirect]);
    }
}
