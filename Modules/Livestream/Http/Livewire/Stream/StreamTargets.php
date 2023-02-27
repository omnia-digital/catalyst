<?php

namespace App\Http\Livewire\Stream;

use App\Actions\Livestream\CreateStreamTargetAction;
use App\Models\LivestreamAccount;
use App\Plans\Features\StreamTargetFeature;
use App\Support\Livestream\WithLivestreamAccount;
use App\Support\Livewire\WithNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * @property LivestreamAccount $livestreamAccount
 */
class StreamTargets extends Component
{
    use WithLivestreamAccount, WithNotification;

    public bool $createStreamTargetModalOpen = false;

    public array $streamTarget = [];

    protected array $rules = [
        'streamTarget.name'       => ['required', 'max:254'],
        'streamTarget.url'        => ['required', 'starts_with:rtmp'],
        'streamTarget.stream_key' => ['required'],
    ];

    public function createStreamTarget()
    {
        $validated = $this->validate();

        $stream = $this->livestreamAccount->defaultStream();

        if (!$stream) {
            $this->error('Could not find Stream. Please make sure you have created one.');

            return;
        }

        if (Auth::user()->currentTeam->hasReachedLimit(StreamTargetFeature::class)) {
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
            'streamTargets' => $streamTargets
        ]);
    }
}
