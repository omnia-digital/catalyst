<?php

namespace Modules\Livestream\Http\Livewire\Stream;

use Livewire\Component;
use Modules\Livestream\Actions\Livestream\CreateStreamTargetAction;
use Modules\Livestream\Models\LivestreamAccount;
use Modules\Livestream\Plans\Features\StreamTargetFeature;
use Modules\Livestream\Support\Livestream\WithLivestreamAccount;
use Modules\Livestream\Support\Livewire\WithNotification;

/**
 * @property LivestreamAccount $livestreamAccount
 */
class StreamTargets extends Component
{
    use WithLivestreamAccount, WithNotification;

    public bool $createStreamTargetModalOpen = false;

    public array $streamTarget = [];

    protected array $rules = [
        'streamTarget.name' => ['required', 'max:254'],
        'streamTarget.url' => ['required', 'starts_with:rtmp'],
        'streamTarget.stream_key' => ['required'],
    ];

    public function createStreamTarget()
    {
        $validated = $this->validate();

        $stream = $this->livestreamAccount->defaultStream();

        if (! $stream) {
            $this->error('Could not find Stream. Please make sure you have created one.');

            return;
        }

        if (auth()->user()->currentTeam->hasReachedLimit(StreamTargetFeature::class)) {
            $this->reset('createStreamTargetModalOpen');
            $this->upgradePlan();

            return;
        }

        (new CreateStreamTargetAction)->execute($stream, $validated['streamTarget']);

        $this->reset('streamTarget', 'createStreamTargetModalOpen');
        $this->success('Create stream target successfully!');
    }

    public function render()
    {
        $streamTargets = $this->livestreamAccount->streamTargets()
            ->latest()
            ->get();

        return view('stream.stream-targets', [
            'streamTargets' => $streamTargets,
        ]);
    }
}
