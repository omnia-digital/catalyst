<?php namespace App\Http\Livewire\Episode;

use App\Models\EpisodeTemplate;
use App\Models\LivestreamAccount;
use App\Support\Livestream\WithLivestreamAccount;
use App\Support\Livewire\WithNotification;
use App\Support\Series\WithSeries;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\ValidationRules\Rules\Delimited;

/**
 * @property LivestreamAccount $livestreamAccount
 * @property array $series
 */
class UpdateTemplate extends Component
{
    use WithFileUploads, WithNotification, AuthorizesRequests, WithLivestreamAccount, WithSeries;

    public EpisodeTemplate $episodeTemplate;

    public ?string $name = null;

    public ?string $title = null;

    public ?string $description = null;

    public ?string $currentThumbnail = null;

    public $thumbnail = null;

    public array $selectedSeries = [];

    public ?string $topics = null;

    public bool $deleteEpisodeTemplateModalOpen = false;

    protected function rules(): array
    {
        return [
            'name'           => ['required', 'max:254'],
            'title'          => ['required'],
            'description'    => ['required'],
            'thumbnail'      => ['nullable', 'image', 'max:2048'],
            'selectedSeries' => ['nullable'],
            'topics'         => ['nullable', new Delimited('string')],
        ];
    }

    public function mount(EpisodeTemplate $episodeTemplate)
    {
        $this->authorize('update', $episodeTemplate);

        $this->episodeTemplate = $episodeTemplate;
        $this->name = $episodeTemplate->title;
        $this->title = $episodeTemplate->template['title'] ?? null;
        $this->description = $episodeTemplate->template['description'] ?? null;
        $this->currentThumbnail = $episodeTemplate->defaultThumbnailUrl;
        $this->selectedSeries = $episodeTemplate->series()->pluck('series_id')->all();
        $this->topics = $episodeTemplate->tagsWithType('topic')->implode('name', ',');
    }

    public function updateEpisodeTemplate()
    {
        $this->authorize('update', $this->episodeTemplate);

        $this->validate();

        $this->episodeTemplate->update([
            'title'             => $this->name,
            'template'          => [
                'title'       => $this->title,
                'description' => $this->description
            ],
            'default_thumbnail' => $this->thumbnail ? $this->thumbnail->store('thumbnails', 'episode-templates') : $this->episodeTemplate->default_thumbnail
        ]);

        $this->episodeTemplate->series()->sync($this->selectedSeries);
        $this->episodeTemplate->syncTopics($this->topics);

        $this->success('Update episode template successfully!');
    }

    public function deleteEpisodeTemplate()
    {
        $this->authorize('delete', $this->episodeTemplate);

        Storage::disk('episode-templates')->delete($this->episodeTemplate->default_thumbnail);

        $this->episodeTemplate->delete();

        $this->redirectRoute('episode-templates');
    }

    public function render()
    {
        return view('episode.update-template', [
            'series' => $this->series
        ]);
    }
}
