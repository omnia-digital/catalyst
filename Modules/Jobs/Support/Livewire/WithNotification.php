<?php namespace Modules\Jobs\Support\Livewire;

trait WithNotification
{
    /**
     * Show success notification.
     *
     * @param string $message
     * @param string|null $actionUrl
     */
    public function success(string $message, ?string $actionUrl = null)
    {
        $this->dispatchBrowserEvent('notify', [
            'message' => $message,
            'type'    => 'success',
            'action'  => $actionUrl
        ]);
    }

    /**
     * Show error notification.
     *
     * @param string $message
     * @param string|null $actionUrl
     */
    public function error(string $message, ?string $actionUrl = null)
    {
        $this->dispatchBrowserEvent('notify', [
            'message' => $message,
            'type'    => 'error',
            'action'  => $actionUrl
        ]);
    }

    /**
     * Show a friendly message to let user knows at least a field is input wrong.
     *
     * @param string|null $message
     */
    public function alertInvalidInput(?string $message = null)
    {
        $this->error($message ?? 'Please make sure all fields are input correctly.');
    }
}
