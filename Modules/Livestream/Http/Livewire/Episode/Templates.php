<?php namespace Modules\Livestream\Http\Livewire\Episode;

use Modules\Livestream\Models\LivestreamAccount;
use Modules\Livestream\Support\Livestream\WithLivestreamAccount;
use Modules\Livestream\Support\Livewire\WithNotification;
use Modules\Livestream\Support\Series\WithSeries;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\ValidationRules\Rules\Delimited;

/**
 * @property LivestreamAccount $livestreamAccount
 * @property array $series
 */
class Templates extends Component
{
    use WithLivestreamAccount, WithFileUploads, WithNotification, WithSeries;

    public bool $createEpisodeTemplateModalOpen = false;

    public ?string $name = null;

    public ?string $title = null;

    public ?string $description = null;

    public $thumbnail = null;

    public array $selectedSeries = [];

    public ?string $topics = null;

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

    public function createEpisodeTemplate()
    {
        $this->validate();

        $template = $this->livestreamAccount->episodeTemplates()->create([
            'title'             => $this->name,
            'template'          => [
                'title'       => $this->title,
                'description' => $this->description
            ],
            'default_thumbnail' => $this->thumbnail?->store('thumbnails', 'episode-templates')
        ]);

        $template->series()->sync($this->selectedSeries);
        $template->syncTopics($this->topics);

        $this->redirectRoute('episode-templates.update', $template);
    }

    public function setDefault($episodeTemplateId)
    {
        $this->livestreamAccount->update(['default_episode_template_id' => $episodeTemplateId]);

        $this->success('Set episode template as default successfully!');
    }

    public function render()
    {
        $episodeTemplates = $this->livestreamAccount->episodeTemplates()
            ->latest()
            ->get();

        return view('episode.templates', [
            'episodeTemplates'         => $episodeTemplates,
            'defaultEpisodeTemplateId' => $this->livestreamAccount->refresh()->default_episode_template_id,
            'series'                   => $this->series
        ]);
    }
}
