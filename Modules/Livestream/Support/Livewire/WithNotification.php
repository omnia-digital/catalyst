<?php

namespace Modules\Livestream\Support\Livewire;

trait WithNotification
{
    /**
     * Show success notification.
     */
    public function success(string $message, ?array $action = null)
    {
        $this->dispatchBrowserEvent('notify', [
            'message' => $message,
            'type' => 'success',
            'action' => $action,
        ]);
    }

    /**
     * Show error notification.
     */
    public function error(string $message, ?array $action = null)
    {
        $this->dispatchBrowserEvent('notify', [
            'message' => $message,
            'type' => 'error',
            'action' => $action,
        ]);
    }

    /**
     * Show a friendly message to let user knows at least a field is input wrong.
     */
    public function alertInvalidInput(?string $message = null)
    {
        $this->error($message ?? 'Please make sure all fields are input correctly.');
    }

    /**
     * Show the modal to call users upgrade their plan.
     */
    public function upgradePlan(?string $title = null, ?string $description = null)
    {
        $this->dispatchBrowserEvent('upgrade-plan', compact('title', 'description'));
    }
}