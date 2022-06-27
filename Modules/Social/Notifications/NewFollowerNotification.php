<?php

namespace Modules\Social\Notifications;

use App\Models\User;
use App\Support\Notification\NotificationCenter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewFollowerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private User $follower
    ){}

    public function via($notifiable): array
    {
        return ['broadcast', 'database'];
    }

    public function toArray($notifiable): array
    {
        return NotificationCenter::make()
            ->icon('heroicon-o-user')
            ->info($this->follower->name . ' followed you')
            ->image($this->follower->profile_photo_url)
            ->actionLink($this->follower->url())
            ->actionText('View')
            ->toArray();
    }
}
