<?php

namespace Modules\Social\Notifications;

use App\Models\Team;
use App\Support\Notification\NotificationCenter;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Trans;

class DailyReminderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        private Team $team,
        private $message,
        private $url = null
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($notifiable->hasTeamRole($this->team, 'leader')) {
            return ['broadcast', 'database'];
        }

        return [];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', 'https://laravel.com')
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $url = $this->url ?? $this->team->profile();
        
        return NotificationCenter::make()
            ->icon('heroicon-o-information-circle')
            ->info(Trans::get($this->message))
            ->image($this->team->profile_photo_url)
            ->actionLink($url)
            ->actionText('View')
            ->toArray();
    }
}
