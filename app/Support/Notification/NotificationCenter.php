<?php

namespace App\Support\Notification;

use Illuminate\Support\Carbon;

class NotificationCenter
{
    const LEVELS = ['info', 'success', 'error'];

    protected array $notification = [];

    public function __construct($title = null, $subtitle = null)
    {
        if (! empty($title)) {
            $this->title($title);
        }

        if (! empty($subtitle)) {
            $this->subtitle($subtitle);
        }

        $this
            ->showMarkAsRead()
            ->showCancel()
            ->playSound()
            ->createdAt(now());
    }

    public static function make(...$arguments): self
    {
        return new static(...$arguments);
    }

    public function title(string $value): NotificationCenter
    {
        $this->notification['title'] = $value;

        return $this;
    }

    public function subtitle(string $value): NotificationCenter
    {
        $this->notification['subtitle'] = $value;

        return $this;
    }

    public function createdAt(Carbon $value): self
    {
        $this->notification['created_at'] = $value->toAtomString();

        return $this;
    }

    public function playSound(bool $value = true): self
    {
        $this->notification['play_sound'] = $value;

        return $this;
    }

    public function showCancel(bool $value = true): self
    {
        $this->notification['show_cancel'] = $value;

        return $this;
    }

    public function showMarkAsRead(bool $value = true): self
    {
        $this->notification['show_mark_as_read'] = $value;

        return $this;
    }

    public function actionLink(string $value): self
    {
        $this->notification['action_link'] = $value;

        return $this;
    }

    public function actionText(string $value): self
    {
        $this->notification['action_text'] = $value;

        return $this;
    }

    public function info(string $value): self
    {
        return $this
            ->title($value)
            ->level('info');
    }

    public function level(string $value): self
    {
        if (! in_array($value, self::LEVELS)) {
            $value = 'info';
        }

        $this->notification['level'] = $value;

        return $this;
    }

    public function success(string $value): self
    {
        return $this
            ->title($value)
            ->level('success');
    }

    public function danger(string $value): self
    {
        return $this
            ->title($value)
            ->level('danger');
    }

    public function warning(string $value): self
    {
        return $this
            ->title($value)
            ->level('warning');
    }

    public function image(string $value): self
    {
        $this->notification['image'] = $value;

        return $this;
    }

    public function icon(string $value): self
    {
        $this->notification['icon'] = $value;

        return $this;
    }

    public function sound(string $value): self
    {
        $this->notification['sound'] = $value;

        return $this;
    }

    public function toArray(): array
    {
        return $this->notification;
    }
}
