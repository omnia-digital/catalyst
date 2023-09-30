<?php

namespace Modules\Social\Notifications;

use App\Models\Team;
use App\Models\User;
use App\Notifications\BaseNotification;
use App\Support\Notification\NotificationCenter;
use Trans;

class NewApplicationToTeamNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        private Team $team,
        private User $applicant
    ) {
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     */
    public function toArray($notifiable): array
    {
        $url = $this->team->profile();

        return NotificationCenter::make()
            ->icon('heroicon-o-user')
            ->success(Trans::get($this->applicant->name . ' applied to your team, ' . $this->team->name))
            ->image($this->applicant->profile_photo_url)
            ->actionLink($url)
            ->actionText('View')
            ->toArray();
    }
}
