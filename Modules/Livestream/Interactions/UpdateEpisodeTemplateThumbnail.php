<?php

namespace Modules\Livestream\Interactions;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use SplFileInfo;

class UpdateEpisodeTemplateThumbnail
{
    /**
     * The image manager instance.
     *
     * @var ImageManager
     */
    protected $images;

    /**
     * Create a new interaction instance.
     *
     * @return void
     */
    public function __construct(ImageManager $images)
    {
        $this->images = $images;
    }

    public function validator($episodeTemplate, array $data)
    {
        return Validator::make($data, [
            'default_thumbnail' => 'required|image',
        ]);
    }

    public function handle($episodeTemplate, array $data)
    {
        $file = $data['default_thumbnail'];
        $team = $episodeTemplate->livestreamAccount->team;
        $teamDirectoryPath = 'teams/' . $team->id;
        $path = $file->hashName($teamDirectoryPath);

        // We will store the profile photos on the "public" disk, which is a convention
        // for where to place assets we want to be publicly accessible. Then, we can
        // grab the URL for the image to store with this user in the database row.
        $storage = Storage::disk('s3-images');

        // [WEB-69]
        $storage->put($path, $this->formatImage($file), 'public');
        $oldPhotoUrl = $episodeTemplate->default_thumbnail;

        // Next, we'll update this URL on the local episode instance and save it to the DB
        // so we can access it later. Then we will delete the old photo from storage
        // since we'll no longer need to access it for this specific episode.
        $episodeTemplate->forceFill([
            'default_thumbnail' => $storage->url($path),
        ])->save();

        if (preg_match('/teams\/' . $team->id . '\/(.*)$/', $oldPhotoUrl, $matches)) {
            $storage->delete('teams\/' . $team->id . '\/' . $matches[1]);
        }
    }

    /**
     * Resize an image instance for the given file.
     *
     * @param  SplFileInfo  $file
     * @return Image
     */
    protected function formatImage($file)
    {
        return (string) $this->images->make($file->path())->fit(1920, 1080)->encode();
    }
}
