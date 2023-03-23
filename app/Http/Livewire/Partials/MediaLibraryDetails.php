<?php

namespace App\Http\Livewire\Partials;

use App\Traits\WithSlideOver;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaLibraryDetails extends Component
{
    use WithSlideOver;

    public ?Media $media = null;

    protected $listeners = [
        'mediaSelected'    => 'findMedia',
        'media-deselected' => 'resetMedia',
    ];

    public function mount($mediaId = null)
    {
        $this->findMedia($mediaId);
    }

    public function findMedia($mediaId)
    {
        // Don't do anything when user select same media.
        if ($mediaId === $this->media?->id) {
            return;
        }

        $this->media = Media::find($mediaId);

        // Dispatch event for open the over-slide on mobile
        $this->showSlideOver();
    }

    public function getModelName($model)
    {
        $column = match (class_basename($model)) {
            Post::class => 'body',
            Team::class => 'name',
            Profile::class => 'handle',
            default => 'name'
        };

        return $model->$column;
    }

    public function render()
    {
        return view('livewire.partials.media-library-details');
    }
}
