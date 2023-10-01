<?php

namespace Modules\Billing\Notifications;

use App\Models\Team;
use App\Support\Notification\NotificationCenter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Laravel\Cashier\Subscription;

class TeamMemberSubscriptionCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        protected Subscription $subscription,
        protected Team $team
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
        return ['mail', 'broadcast', 'database'];
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
            ->subject('New Subscription')
            ->line('Your team ' . $this->team->name . ' has a new subscription.')
            ->action('View', route('social.teams.admin', $this->team))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toArray($notifiable): array
    {
        return NotificationCenter::make()
            ->icon('heroicon-o-cash')
            ->success('New subscription')
            ->subtitle($this->team->name)
            //->image()
            ->actionLink(route('social.teams.admin', $this->team))
            ->actionText('View')
            ->toArray();
    }
}
