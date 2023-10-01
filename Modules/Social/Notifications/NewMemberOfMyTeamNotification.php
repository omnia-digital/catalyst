<?php

namespace Modules\Social\Notifications;

use App\Models\Team;
use App\Models\User;
use App\Notifications\BaseNotification;
use App\Support\Notification\NotificationCenter;
use Trans;

class NewMemberOfMyTeamNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        private Team $team,
        private User $newMember
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($notifiable->id === $this->newMember->id) {
            return [];
        }

        return static::getChannels();
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $url = $this->team->profile();

        return NotificationCenter::make()
            ->icon('heroicon-o-user')
            ->success(Trans::get($this->newMember->name . ' has been added to the team, ' . $this->team->name))
            ->image($this->newMember->profile_photo_url)
            ->actionLink($url)
            ->actionText('View')
            ->toArray();
    }
}
