<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notifications extends Component
{
    public int $perPage = 10;

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

    public function showAlert($notification): void
    {
        $this->info($notification['title']);
    }

    public function loadMore(): void
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

    public function render(): \Illuminate\View\View
    {
        return view('livewire.notifications', [
            'notifications' => $this->rows,
            'allNotificationCount' => $this->allNotificationCount
        ]);
    }
}
