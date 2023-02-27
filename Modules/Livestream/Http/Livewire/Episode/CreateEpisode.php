<?php

namespace App\Http\Livewire\Episode;

use App\Actions\Episodes\CreateNewEpisode;
use App\Actions\Episodes\DetectFileTypeFromUrl;
use App\Services\Mux\MuxUploader;
use JetBrains\PhpStorm\ArrayShape;
use Livewire\Component;

class CreateEpisode extends Component
{
    public bool $hasMedia = true;

    public bool $isUpload = true;

    public ?string $url = null;

    public ?string $title = null;

    #[ArrayShape(['url' => "string", 'id' => "string"])]
    public function createMuxUploader(): array
    {
        $uploader = app(MuxUploader::class)->make();

        return [
            'url' => $uploader['data']->getUrl(),
            'id'  => $uploader['id']
        ];
    }

    public function createEpisodeByUpload(string $title, string $uploadId)
    {
        $episode = (new CreateNewEpisode)->execute([
            'title'         => $title,
            'upload_id'     => $uploadId,
            'date_recorded' => now()
        ]);

        return $episode->id;
    }

    public function createEpisode()
    {
        $this->validate([
            'title' => ['required', 'string'],
        ]);

        (new CreateNewEpisode)->execute([
            'title'         => $this->title,
            'date_recorded' => now()
        ]);

        $this->redirectRoute('episodes');
    }

    public function createEpisodeFromUrl()
    {
        $this->validate([
            'url'   => ['required', 'url'],
            'title' => ['required', 'string'],
        ]);

        $episode = (new CreateNewEpisode)->execute([
            'title'         => $this->title,
            'date_recorded' => now()
        ]);

        $episode->video()->create([
            'file_type'            => (new DetectFileTypeFromUrl)->execute($this->url),
            'title'                => $episode->title,
            'playback_url'         => $this->url,
            'video_source_type_id' => 7 // FromUrlSource ID.
        ]);

        $this->redirectRoute('episodes');
    }

    /* This method for cancelling the upload feature */
    //public function deleteEpisode(string $uploadId)
    //{
    //    Episode::findByUploadId($uploadId)?->delete();
    //}

    public function render()
    {
        return view('episode.create-episode');
    }
}
