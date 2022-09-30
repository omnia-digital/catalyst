<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserNotifications extends Component
{
    public int $perPage = 10;

    public function getListeners()
    {
        return [
            'notificationRead' => 'markAsRead',
            'echo-notification:App.Models.User.' . Auth::id() => '$refresh',
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

    public function loadMore()
    {
        $this->perPage = $this->rowsQuery->count() + $this->perPage;
    }

    public function getRowsQueryProperty()
    {
        return Auth::user()
            ->notifications()
            ->orderByDesc('created_at');
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate($this->perPage);
    }

    public function getAllNotificationCountProperty()
    {
        return Auth::user()->notifications()->count();
    }

    public function render()
    {
        return view('livewire.user-notifications', [
            'notifications' => $this->rows,
            'allNotificationCount' => $this->allNotificationCount
        ]);
    }
}
