<?php

namespace App\Http\Livewire\Pages\Media;

use App\Traits\Filter\WithBulkActions;
use App\Traits\Filter\WithPerPagePagination;
use Carbon\Carbon;
use Livewire\Component;
use Modules\Social\Models\Post;
use Modules\Social\Models\Profile;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;
use OmniaDigital\OmniaLibrary\Livewire\WithLayoutSwitcher;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;
use OmniaDigital\OmniaLibrary\Livewire\WithSorting;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Index extends Component
{
    use WithBulkActions, WithPerPagePagination, WithSorting, WithCachedRows, WithNotification, WithLayoutSwitcher;

    public Media|null $editingMedia = null;
    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showFilters = false;

    public ?int $selectedMedia = null;

    public $availableModelTypes = [
        Episode::class => "Episodes",
    ];

    public $filters = [
        'search' => '',
        'collection' => '',
        'attached_type' => '',
        'date_min' => null,
        'date_max' => null,
    ];

    protected $listeners = [
        'media-deselected' => 'deselectMedia',
        'refreshMedia' => '$refresh'
    ];

    protected function rules() { return [
        'editingMedia.name' => ['nullable', 'max:254'],
        'editingMedia.model_type' => ['string', 'in:' . collect($this->availableModelTypes)->map(fn ($type, $key) => $key)->implode(',')],
        'editingMedia.model_id' => ['integer'],
        'editingMedia.collection_name' => ['string']
    ]; }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = ! $this->showFilters;
    }

    public function resetFilters() { $this->reset('filters'); }

    public function getAttachedTypes()
    {
        return Media::pluck('model_type')->unique()->map(function ($type) { return class_basename($type); })->toArray();   
    }

    public function getCollectionNames()
    {
        return Media::pluck('collection_name')->unique()->toArray();   
    }

    public function deleteSelected()
    {
        $deleteCount = $this->selectedRowsQuery->count();

        $this->selectedRowsQuery->delete();

        $this->showDeleteModal = false;

        $this->success('You\'ve deleted ' . $deleteCount . ' ' . Str::plural('item', $deleteCount));
    }

    public function editMedia(Media $media)
    {
        $this->useCachedRows();

        if ($this->editingMedia?->isNot($media) || is_null($this->editingMedia)) $this->editingMedia = $media;

        $this->showEditModal = true;
    }

    public function saveMedia()
    {
        $this->validate();
        
        $this->editingMedia->save();

        $this->showEditModal = false;
    }

    public function getAvailableModelIdsProperty()
    {
        if (is_null($this->editingMedia?->model_type)) {
            return [];
        }

        return $this->editingMedia->model_type::pluck('title', 'id')->toArray();
    }

    public function selectMedia($media)
    {
        $this->useCachedRows();

        $this->selectedMedia = $media;

        $this->emitTo('partials.media-library-details', 'mediaSelected', $media);
    }

    public function deselectMedia()
    {
        $this->useCachedRows();

        $this->reset('selectedMedia');
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function getRowsQueryProperty()
    {
        return Media::query()
            ->when($this->filters['date_min'], fn($query, $date) => $query->where('created_at', '>=', Carbon::parse($date)))
            ->when($this->filters['date_max'], fn($query, $date) => $query->where('created_at', '<=', Carbon::parse($date)))
            ->when($this->filters['search'], function ($query, $search) { 

                return $query
                    ->whereHasMorph('model', '*', function ($query, $type) use ($search) {
                        $column = match ($type) {
                            Post::class => 'body',
                            Team::class => 'name',
                            Profile::class => 'handle',
                            default => 'name'
                        };

                        return $query->where($column, 'like', '%'.$search.'%'); 
                    })
                    ->orWhere('name', 'like', '%'.$search.'%');
            });
    }

    public function render()
    {
        return view('livewire.pages.media.index', ['mediaList' => $this->rows]);
    }
}
