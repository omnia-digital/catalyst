<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class NotificationGlobal extends Component
{
    use WithNotification;

    /**
     * @return string[]
     *
     * @psalm-return array<string, 'showAlert'>
     */
    public function getListeners()
    {
        return [
            'echo-notification:App.Models.User.' . Auth::id() => 'showAlert',
        ];
    }

    public function markAsRead($notificationId): void
    {
        Auth::user()->notifications()->where('id', $notificationId)->first()?->markAsRead();
    }

    public function showAlert($notification): void
    {
        $this->info($notification['title']);
    }

    public function render(): string
    {
        return '<div></div>';
    }
}
