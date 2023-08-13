<?php

namespace Modules\Livestream\Http\Livewire\Setting;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\Livestream\Enums\VideoStorageOption;
use Modules\Livestream\Models\Episode;
use Modules\Livestream\Models\LivestreamAccount;
use Modules\Livestream\Support\Livestream\WithLivestreamAccount;

/**
 * @property Collection $expiredEpisodes
 * @property LivestreamAccount $livestreamAccount
 */
class VideoSetting extends Component
{
    use WithLivestreamAccount;

    public string $videoStorage = '';

    public int $expiredEpisodeCount = 0;

    public bool $confirmingVideoDeletion = false;

    public function mount()
    {
        $this->videoStorage = $this->livestreamAccount->video_storage_option;
    }

    public function updatedVideoStorage($value)
    {
        // Count how many expired episodes to let users know
        // when they selected delete video option.
        if ($value === VideoStorageOption::DELETE_VIDEO) {
            $this->expiredEpisodeCount = $this->expiredEpisodes->count();
        }
    }

    public function saveVideoStorageOption()
    {
        $this->validate();

        // Show the confirmation modal when select auto-delete.
        if ($this->videoStorage === VideoStorageOption::DELETE_VIDEO && ! $this->confirmingVideoDeletion) {
            $this->confirmingVideoDeletion = true;

            return;
        }

        DB::transaction(function () {
            $this->livestreamAccount->update([
                'video_storage_option' => $this->videoStorage,
            ]);

            if ($this->videoStorage === VideoStorageOption::DELETE_VIDEO) {
                $this->expiredEpisodes->each(fn (Episode $episode) => $episode->delete());
            }
        });

        $this->dispatch('saved');
        $this->reset('confirmingVideoDeletion');
    }

    public function getExpiredEpisodesProperty()
    {
        return $this->livestreamAccount
            ->episodes()
            ->expired()
            ->get();
    }

    public function render()
    {
        return view('setting.video-setting', [
            'videoStorageOptions' => VideoStorageOption::options(),
        ])->layout('layouts.setting');
    }

    protected function rules(): array
    {
        return [
            'videoStorage' => ['required', Rule::in(array_keys(VideoStorageOption::options()))],
        ];
    }
}
