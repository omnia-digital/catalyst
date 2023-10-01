<?php

namespace App\Livewire;

use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class NotificationGlobal extends Component
{
    use WithNotification;

    public function getListeners()
    {
        return [
            'echo-notification:App.Models.User.' . auth()->id() => 'showAlert',
        ];
    }

    public function markAsRead($notificationId)
    {
        auth()->user()->notifications()->where('id', $notificationId)->first()?->markAsRead();
    }

    public function showAlert($notification)
    {
        $this->info($notification['title']);
    }

    public function render()
    {
        return '<div></div>';
    }
}
