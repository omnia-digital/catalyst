<?php

    namespace App\Interactions;

    use Illuminate\Support\Facades\Storage;

    class DeleteLivestreamAccountImage
    {
        /**
         * {@inheritdoc}
         */
        public function handle($livestreamAccount, $imageType)
        {
            $storage = Storage::disk('s3-images');
            $team = $livestreamAccount->team;

            // get current thumbnail url
            $thumbnailPath = $livestreamAccount->{$imageType};

            try {
                if (preg_match('/teams\/' . $team->id . '\/(.*)$/', $thumbnailPath, $matches)) {
                    $storage->delete('teams\/' . $team->id . '\/' . $matches[1]);
                }

                // remove thumbnail path from Episode if deletion of file was successful
                $livestreamAccount->forceFill([
                    $imageType => '',
                ])->save();
            } catch(\Exception $e) {
                throw new \Exception('Could not delete Livestream Account Image:' . $imageType .': ' . $e->getMessage());
            }
        }
    }
