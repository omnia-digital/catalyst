<?php namespace Modules\Jobs\Support\Notification;

use Modules\Jobs\Models\User;

class Notification
{
    protected \Illuminate\Notifications\Notification $notification;

    public function __construct(\Illuminate\Notifications\Notification $notification)
    {
        $this->notification = $notification;
    }

    public static function make(\Illuminate\Notifications\Notification $notification)
    {
        return new static($notification);
    }

    /**
     * Send notification to users who have role Admin.
     *
     * @return void
     */
    public function toAdmin()
    {
        foreach (User::role('Admin')->get() as $admin)
        {
            $admin->notify($this->notification);
        }
    }

    /**
     * Send notification to users who have role Admin.
     *
     * @return void
     */
    public function toContractors()
    {
        foreach (User::role('Contractor')->get() as $contractor)
        {
            $contractor->notify($this->notification);
        }
    }

    /**
     * Send notification to a group of users.
     *
     * @param $users
     * @return void
     */
    public function to($users)
    {
        foreach ($users as $user)
        {
            $user->notify($this->notification);
        }
    }

    /**
     * Send notification to the current user.
     */
    public function toCurrent()
    {
        auth()->user()->notify($this->notification);
    }

    /**
     * Send notification to a specific email.
     *
     * @param string $email
     */
    public function toEmail(string $email)
    {
        \Illuminate\Support\Facades\Notification::route(
            'mail', $email
        )->notify($this->notification);
    }

    /**
     * Send to whatever is defined in relation method.
     *
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        $relation = lcfirst(
            str_replace('to', '', $name)
        );

        $this->to([$arguments[0]->$relation]);
    }
}
