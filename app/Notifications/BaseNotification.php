<?php

namespace App\Notifications;

use App\Support\Notification\NotificationCenter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

abstract class BaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public static string $label = '';
    public static string $description = '';
    public static array $channels = ['mail', 'database', 'broadcast', 'sms'];

    public static function getLabel()
    {
        if (static::$label) {
            return static::$label;
        }
    }

    public static function getDescription()
    {
        if (static::$description) {
            return static::$description;
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return static::getChannels();
    }

    public static function getChannels()
    {
        if (static::$channels) {
            return static::$channels;
        }
    }

    /**
     * @return string[]
     */
    public function getOptInSubscriptions(): array
    {
        return ['sms'];
    }

    public function toMail(object $notifiable)
    {
        $url = route('notifications');

        return (new MailMessage)
            ->greeting('Hello!')
            ->line('You have a new Notification!')
            ->action('View Notifications', $url);
    }

    public function toSms($notifiable)
    {
        return $this->toArray();
//        $url = route('notifications');
//
//        return ()
//            ->greeting('Hello!')
//            ->line('You have a new Notification!')
//            ->action('View Notifications', $url);
    }

    public function toArray($notifiable)
    {
        $url = route('notifications');

        return NotificationCenter::make()
            ->icon('heroicon-o-user-group')
            ->success('Success!')
            ->actionLink($url)
            ->actionText('View Notifications')
            ->toArray();
    }

    /**
     * Get the Vonage / SMS representation of the notification.
     */
//    public function toVonage(object $notifiable): VonageMessage
//    {
//        return (new VonageMessage)
//            ->clientReference((string) $notifiable->id)
//            ->content('Your SMS message content');
//    }
}
