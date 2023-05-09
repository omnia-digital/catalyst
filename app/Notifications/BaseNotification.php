<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

abstract class BaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public static string $label = '';
    public static string $description = '';
    public static array $channels = ['mail', 'database', 'broadcast', 'sms'];

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return static::getChannels();
    }

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
}
