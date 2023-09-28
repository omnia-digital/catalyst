<?php

namespace Modules\Jobs\Support\Livewire;

trait WithNotification
{
    /**
     * Show success notification.
     */
    public function success(string $message, ?string $actionUrl = null)
    {
        $this->dispatch('notify',
            message: $message,
            type: 'success',
            action: $actionUrl
        );
    }

    /**
     * Show error notification.
     */
    public function error(string $message, ?string $actionUrl = null)
    {
        $this->dispatch('notify', [
            'message' => $message,
            'type' => 'error',
            'action' => $actionUrl,
        ]);
    }

    /**
     * Show a friendly message to let user knows at least a field is input wrong.
     */
    public function alertInvalidInput(?string $message = null)
    {
        $this->error($message ?? 'Please make sure all fields are input correctly.');
    }
}
