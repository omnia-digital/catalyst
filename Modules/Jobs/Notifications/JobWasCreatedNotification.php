<?php

namespace Modules\Jobs\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Modules\Jobs\LaraContract;
use Modules\Jobs\Models\JobPosition;

class JobPositionWasCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private JobPosition $job;

    /**
     * Create a new notification instance.
     */
    public function __construct(JobPosition $job)
    {
        $this->job = $job;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('[LaraContracts] New job was posted: ' . $this->job->title)
            ->greeting('Hello, ' . $notifiable->name . '!')
            ->line('Company: ' . $this->job->company->name);

        if ($this->job->is_remote) {
            $message->line('Remote: Yes');
        }

        if ($this->job->location) {
            $message->line('Preferred Location: ' . $this->job->location);
        }

        $message->line('JobPosition Title: ' . $this->job->title)
            ->line('JobPosition Description: ' . $this->job->description);

        if ($this->job->budget) {
            $message->line('Budget: ' . LaraContract::money($this->job->budget));
        }

        $message->line('Payment Type: ' . ucfirst($this->job->payment_type))
            ->action('Apply Now', route('jobs.show', ['team' => $this->job->company, 'job' => $this->job]))
            ->line('Thank you for using ' . config('app.name') . '!');

        return $message;
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param mixed $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->from(config('services.slack.from'), ':ghost:')
            ->to('services.slack.from')
            ->content('JobPosition: ' . $this->job->title . ' was posted by ' . $this->job->company->name);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
