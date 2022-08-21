<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notifications extends Component
{


    /**
     * @return string[]
     *
     * @psalm-return array<string, '$refresh'|'markAsRead'>
     */
    public function getListeners()
    {
        return [
            'notificationRead' => 'markAsRead',
            'echo-notification:App.Models.User.' . Auth::id() => '$refresh',
        ];
    }

    public function markAsRead($notificationId): void
    {
        Auth::user()->notifications()->where('id', $notificationId)->first()?->markAsRead();
    }
}
