<?php

namespace Modules\Social\Support\Livewire;

use App\Rules\CronExpressionValidation;
use Illuminate\Validation\Rule;

trait ManagesTeamNotifications
{
    public $newNotification;

    protected function notificationRules()
    {
        return [
            'name' => ['required', 'min:6'],
            'target_role' => ['nullable', 'in:owner,leader,member'],
            'message' => ['required', 'min:10'],
            'expression' => ['required', new CronExpressionValidation],
        ];
    }
    public function addTeamNotification()
    {
        $validated = $this->validate($this->notificationRules());
        $this->team->teamNotifications()->create($validated);
    }
}