<?php

    namespace Modules\Livestream\Interactions;

    use Illuminate\Support\Facades\Storage;

    class DeleteEpisodeTemplateThumbnail
    {
        /**
         * {@inheritdoc}
         */
        public function handle($episodeTemplate)
        {
            $storage = Storage::disk('s3-images');
            $team = $episodeTemplate->livestreamAccount->team;

            // get current thumbnail url
            $thumbnailPath = $episodeTemplate->default_thumbnail;

            try {
                if (preg_match('/teams\/' . $team->id . '\/(.*)$/', $thumbnailPath, $matches)) {
                    $storage->delete('teams\/' . $team->id . '\/' . $matches[1]);
                }

                // remove thumbnail path from Episode if deletion of file was successful
                $episodeTemplate->forceFill([
                    'default_thumbnail' => '',
                ])->save();
            } catch(\Exception $e) {
                throw new \Exception('Could not delete Episode Template Thumbnail: ' . $e->getMessage());
            }
        }
    }
