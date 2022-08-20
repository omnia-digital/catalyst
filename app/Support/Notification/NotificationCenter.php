<?php

namespace App\Support\Notification;

use Illuminate\Support\Carbon;

class NotificationCenter
{
    const LEVELS = ['info', 'success', 'error'];

    protected array $notification = [];

    public function __construct($title = null, $subtitle = null)
    {
        if (!empty($title)) {
            $this->title($title);
        }

        if (!empty($subtitle)) {
            $this->subtitle($subtitle);
        }

        $this
            ->showMarkAsRead()
            ->showCancel()
            ->playSound()
            ->createdAt(now());
    }

    public static function make(...$arguments): static
    {
        return new static(...$arguments);
    }

    public function title(string $value): static
    {
        $this->notification['title'] = $value;

        return $this;
    }

    public function subtitle(string $value): static
    {
        $this->notification['subtitle'] = $value;

        return $this;
    }

    public function actionLink(string $value): static
    {
        $this->notification['action_link'] = $value;

        return $this;
    }

    public function actionText(string $value): static
    {
        $this->notification['action_text'] = $value;

        return $this;
    }

    public function level(string $value): static
    {
        if (!in_array($value, self::LEVELS)) {
            $value = 'info';
        }

        $this->notification['level'] = $value;

        return $this;
    }

    public function info(string $value): self
    {
        return $this
            ->title($value)
            ->level('info');
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

    public function image(string $value): static
    {
        $this->notification['image'] = $value;

        return $this;
    }

    public function createdAt(Carbon $value): static
    {
        $this->notification['created_at'] = $value->toAtomString();

        return $this;
    }

    public function icon(string $value): static
    {
        $this->notification['icon'] = $value;

        return $this;
    }

    public function showMarkAsRead(bool $value = true): static
    {
        $this->notification['show_mark_as_read'] = $value;

        return $this;
    }

    public function showCancel(bool $value = true): static
    {
        $this->notification['show_cancel'] = $value;

        return $this;
    }

    public function playSound(bool $value = true): static
    {
        $this->notification['play_sound'] = $value;

        return $this;
    }

    public function toArray(): array
    {
        return $this->notification;
    }
}
