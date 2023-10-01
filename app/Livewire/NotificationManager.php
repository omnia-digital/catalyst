<?php

namespace App\Livewire;

use Livewire\Component;
use Modules\Social\Notifications\ApplicationAcceptedToTeamNotification;
use Modules\Social\Notifications\NewApplicationToTeamNotification;
use Modules\Social\Notifications\NewCommentNotification;
use Modules\Social\Notifications\NewFollowerNotification;
use Modules\Social\Notifications\NewMemberOfMyTeamNotification;

class NotificationManager extends Component
{
    public $user;

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function getAllNotificationsProperty()
    {
        return [
            ApplicationAcceptedToTeamNotification::class,
            NewApplicationToTeamNotification::class,
            NewCommentNotification::class,
            NewFollowerNotification::class,
            NewMemberOfMyTeamNotification::class,
        ];
    }

    public function getChannelLabel($channel)
    {
        return match ($channel) {
            'mail' => 'Email',
            'database' => 'In-App',
            'broadcast' => 'Push',
            'sms' => 'SMS',
            default => 'Unknown',
        };
    }

    public function getSubscriptionsProperty()
    {
        return $this->user->notificationSubscriptions();
    }

    public function render()
    {
        return view('livewire.notification-manager');
    }
}
