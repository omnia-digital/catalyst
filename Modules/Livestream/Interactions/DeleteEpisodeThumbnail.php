<?php

    namespace App\Interactions;

    use Illuminate\Support\Facades\Storage;

    class DeleteEpisodeThumbnail
    {
        /**
         * {@inheritdoc}
         */
        public function handle($episode)
        {
            $storage = Storage::disk('s3-images');
            $team = $episode->livestreamAccount->team;

            // get current thumbnail url
            $thumbnailPath = $episode->thumbnail;

            try {
                if (preg_match('/teams\/' . $team->id . '\/(.*)$/', $thumbnailPath, $matches)) {
                    $storage->delete('teams\/' . $team->id . '\/' . $matches[1]);
                }

                // remove thumbnail path from Episode if deletion of file was successful
                $episode->forceFill([
                    'thumbnail' => '',
                ])->save();
            } catch(\Exception $e) {
                throw new \Exception('Could not delete Episode Thumbnail: ' . $e->getMessage());
            }
        }
    }
