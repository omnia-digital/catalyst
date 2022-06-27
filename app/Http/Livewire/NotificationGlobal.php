<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class NotificationGlobal extends Component
{
    use WithNotification;

    public function getListeners()
    {
        return [
            'echo-notification:App.Models.User.' . Auth::id() => 'showAlert',
        ];
    }

    public function markAsRead($notificationId)
    {
        Auth::user()->notifications()->where('id', $notificationId)->first()?->markAsRead();
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
