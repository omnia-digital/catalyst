<?php

namespace Modules\Livestream\Http\Livewire\Episode;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Livestream\Models\Episode;
use Modules\Livestream\Models\Person;
use Modules\Livestream\Support\Livewire\WithCachedRows;
use Modules\Livestream\Support\Livewire\WithLayoutSwitcher;
use Modules\Livestream\Support\Livewire\WithSlideUp;

/**
 * @property Builder $rowsQueryWithoutFilters
 */
class Episodes extends Component
{
    use WithPagination, WithLayoutSwitcher, WithCachedRows, WithSlideUp;

    public bool $multiSelectMode = false;

    public bool $massAttachmentUpload = false;

    public array $selectedIDs = [];

    public ?int $selectedEpisode = null;

    public ?string $search = null;

    public array $filters = [
        'speaker' => '',
        'date_recorded' => '',
        'has_attachment' => false,
    ];

    public string $orderBy = 'date_recorded';

    protected $listeners = [
        'episode-deselected' => 'deselectEpisode',
        'episode-deleted' => '$refresh',
    ];

    protected $queryString = [
        'search',
    ];

    public function mount(Episode $episode)
    {
        $this->selectEpisode($episode->id);
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function selectEpisode($episode)
    {
        if ($this->multiSelectMode) {
            $this->multiSelect($episode);

            return;
        }

        $this->useCachedRows();

        $this->selectedEpisode = $episode;

        $this->emitTo('episode.episode-info-panel', 'episodeSelected', $episode);
    }

    public function toggleMassAttachmentUpload()
    {
        if ($this->massAttachmentUpload) {
            $this->massAttachmentUpload = false;

            return;
        }

        $this->turnOffMultiSelect();
        $this->massAttachmentUpload = true;
    }

    public function toggleMultiSelect()
    {
        if ($this->multiSelectMode) {
            $this->turnOffMultiSelect();
            $this->hideSlideUp();

            return;
        }

        $this->massAttachmentUpload = false;
        if ($this->selectedEpisode) {
            array_push($this->selectedIDs, $this->selectedEpisode);
        }
        $this->deselectEpisode();
        $this->multiSelectMode = true;
        $this->showSlideUp();
    }

    public function turnOffMultiSelect()
    {
        $this->multiSelectMode = false;
        $this->selectedIDs = [];
    }

    public function multiSelect($id)
    {
        if (in_array($id, $this->selectedIDs)) {
            $this->multiDeselect($id);
        } else {
            array_push($this->selectedIDs, $id);
        }

        $this->emitTo('episode.multi-select-panel', 'updateSelectedEpisodes', $this->selectedIDs);
    }

    public function multiDeselect($id)
    {
        if (($key = array_search($id, $this->selectedIDs)) !== false) {
            unset($this->selectedIDs[$key]);
        }
    }

    public function deselectEpisode()
    {
        $this->useCachedRows();

        $this->reset('selectedEpisode');
    }

    public function sortBy(string $orderBy)
    {
        if ($orderBy === $this->orderBy) {
            return;
        }

        $this->orderBy = $orderBy;
    }

    public function getRowsQueryProperty()
    {
        $query = clone $this->rowsQueryWithoutFilters;

        return $query
            ->when($this->orderBy === 'date_recorded', fn ($query) => $query->orderBy('date_recorded', 'desc'))
            ->when($this->orderBy === 'views', fn ($query) => $query->orderBy('video_views_count', 'desc'))
            ->when(Arr::get($this->filters, 'speaker'), fn ($query, $speakerId) => $query->where('main_speaker_id', $speakerId))
            ->when(Arr::get($this->filters, 'date_recorded'), fn ($query, $dateRecorded) => $query->whereDate('date_recorded', Carbon::parse($dateRecorded)))
            ->when(Arr::get($this->filters, 'has_attachment'), fn ($query) => $query->has('media'))
            ->when(! empty($this->search), fn ($query) => $query->where('title', 'LIKE', "%{$this->search}%"));
    }

    public function getRowsQueryWithoutFiltersProperty()
    {
        return auth()->user()->currentTeam
            ?->livestreamAccount
            ->episodes()
            ->with(['mainSpeaker', 'video', 'livestreamAccount.team', 'category', 'series', 'media'])
            ->withCount(['videoViews', 'media']);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate(24);
        });
    }

    public function getSpeakersProperty()
    {
        $speakerIds = $this->rowsQueryWithoutFilters->pluck('main_speaker_id');

        return Person::select(['first_name', 'last_name', 'id'])
            ->whereIn('id', $speakerIds)
            ->get()
            ->pluck('name', 'id');
    }

    public function render()
    {
        return view('episode.episodes', [
            'episodes' => $this->rows,
            'speakers' => $this->speakers,
        ]);
    }
}
