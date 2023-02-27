<?php namespace App\Http\Livewire\Stream;

use App\Models\StreamTarget;
use App\Services\Mux\MuxLivestream;
use App\Support\Livewire\WithNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class UpdateStreamTarget extends Component
{
    use WithNotification, AuthorizesRequests;

    public StreamTarget $streamTarget;

    public bool $deleteStreamTargetModalOpen = false;

    protected array $rules = [
        'streamTarget.name' => ['required', 'max:254'],
    ];

    public function mount()
    {
        $this->authorize('update', $this->streamTarget);
    }

    public function updateStreamTarget()
    {
        $this->authorize('update', $this->streamTarget);

        $this->validate();

        $this->streamTarget->save();

        $this->success('Update stream target successfully!');
    }

    public function deleteStreamTarget()
    {
        $this->authorize('delete', $this->streamTarget);

        app(MuxLivestream::class)->deleteSimulcastTargets(
            $this->streamTarget->stream->stream_id,
            $this->streamTarget->mux_simulcast_target_id
        );

        $this->streamTarget->delete();

        $this->redirectRoute('stream-targets');
    }

    public function render()
    {
        return view('stream.update-stream-target');
    }
}
