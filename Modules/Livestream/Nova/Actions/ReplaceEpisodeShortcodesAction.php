<?php

namespace App\Nova\Actions;

use App\Omnia;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class ReplaceEpisodeShortcodesAction extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $episode) {
            $title = $episode->title;
            $description = $episode->description;

            $episode->title = Omnia::replaceShortcodesInStringUsingGivenTimestamp($title, $episode->created_at);
            $episode->description = Omnia::replaceShortcodesInStringUsingGivenTimestamp($description, $episode->created_at);
            $episode->save();
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
