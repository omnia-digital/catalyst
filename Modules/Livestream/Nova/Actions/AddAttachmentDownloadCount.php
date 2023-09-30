<?php

namespace Modules\Livestream\Nova\Actions;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Modules\Livestream\Models\OldAnalytics;

class AddAttachmentDownloadCount extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $episode) {
            $oldMedia = OldAnalytics::where('name', 'like',
                '%' . implode('%', explode('-', $episode->title)) . '%')->first();
            !is_null($oldMedia) && $episode->downloads()->create([
                'count' => $oldMedia->count,
                'created_at' => Carbon::parse('December 01 2021'),
                'updated_at' => Carbon::parse('December 01 2021'),
            ]);

            foreach ($episode->media as $attachment) {
                $oldAttachment = OldAnalytics::where('name', 'like',
                    '%' . implode('%', explode('-', $attachment->file_name)) . '%')->first();
                !is_null($oldAttachment) && $attachment->downloads()->create([
                    'count' => $oldAttachment->count,
                    'created_at' => Carbon::parse('December 01 2021'),
                    'updated_at' => Carbon::parse('December 01 2021'),
                ]);
            }
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
