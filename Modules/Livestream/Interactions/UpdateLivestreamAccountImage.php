<?php

namespace Modules\Livestream\Interactions;

    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Facades\Validator;
    use Intervention\Image\ImageManager;
use SplFileInfo;

    class UpdateLivestreamAccountImage
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

        public function validator($livestreamAccount, $imageType, array $data)
        {
            return Validator::make($data, [
                $imageType => 'required',
            ]);
        }

        public function handle($livestreamAccount, $imageType, array $data)
        {
            $file = $data[$imageType];
            $team = $livestreamAccount->team;
            $teamDirectoryPath = 'teams/' . $team->id;
            $path = $file->hashName($teamDirectoryPath);

            // We will store the profile photos on the "public" disk, which is a convention
            // for where to place assets we want to be publicly accessible. Then, we can
            // grab the URL for the image to store with this user in the database row.
            $storage = Storage::disk('s3-images');

            // [WEB-69]
            $storage->put($path, $this->formatImage($file), 'public');
            $oldPhotoUrl = $livestreamAccount->{$imageType};

            // Next, we'll update this URL on the local episode instance and save it to the DB
            // so we can access it later. Then we will delete the old photo from storage
            // since we'll no longer need to access it for this specific episode.
            $livestreamAccount->forceFill([
                $imageType => $storage->url($path),
            ])->save();

            if (preg_match('/teams\/' . $team->id . '\/(.*)$/', $oldPhotoUrl, $matches)) {
                $storage->delete('teams\/' . $team->id . '\/' . $matches[1]);
            }
        }

        /**
         * Resize an image instance for the given file.
         *
         * @param  SplFileInfo  $file
         * @return \Intervention\Image\Image
         */
        protected function formatImage($file)
        {
            return (string) $this->images->make($file->path())->fit('1920', '1080')->encode();
        }
    }
