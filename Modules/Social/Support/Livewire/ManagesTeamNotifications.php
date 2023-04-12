<?php

namespace Modules\Social\Support\Livewire;

use App\Rules\CronExpressionValidation;

trait ManagesTeamNotifications
{
    public $newNotification;

    public function addTeamNotification()
    {
        $validated = $this->validate($this->notificationRules());
        $this->team->teamNotifications()->create($validated);
    }

    protected function notificationRules()
    {
        return [
            'name' => ['required', 'min:6'],
            'target_role' => ['nullable', 'in:owner,leader,member'],
            'message' => ['required', 'min:10'],
            'expression' => ['required', new CronExpressionValidation],
        ];
    }
}
