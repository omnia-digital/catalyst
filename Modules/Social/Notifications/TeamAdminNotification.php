<?php

namespace Modules\Social\Notifications;

use App\Models\Team;
use App\Notifications\BaseNotification;
use App\Support\Notification\NotificationCenter;
use Illuminate\Notifications\Messages\MailMessage;
use OmniaDigital\CatalystCore\Facades\Translate;

class TeamAdminNotification extends BaseNotification
{
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        private Team $team,
        private $message
    ) {
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(Translate::get('You have a new message from the team: ' . $this->team->name))
            ->line(Translate::get('You have a new message from the team: ' . $this->team->name))
            ->line($this->message)
            ->action('View Team', $this->team->profile());
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
            ->icon('heroicon-o-user-group')
            ->info(Translate::get('You have a new message from the team: ' . $this->team->name))
            ->image($this->team->profile_photo_url)
            ->subtitle($this->message)
            ->actionLink($url)
            ->actionText('View')
            ->toArray();
    }
}
