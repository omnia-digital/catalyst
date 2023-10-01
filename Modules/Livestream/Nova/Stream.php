<?php

namespace Modules\Livestream\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Text;
use Modules\Livestream\Models\Stream as StreamModel;
use Modules\Livestream\Nova\Actions\DisableStream;
use Modules\Livestream\Nova\Actions\EnableStream;

class Stream extends Resource
{
    public static $model = StreamModel::class;

    public static $group = 'Livestream';

    public static $title = 'id';

    public static $search = [
        'stream_id',
    ];

    /**
     * The relationship columns that should be searched.
     *
     * @var array
     */
    public static $searchRelations = [
        'livestreamAccount' => ['id'],
        'livestreamAccount.team' => ['name'],
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Label'),

            Text::make('Stream ID')->sortable(),

            Text::make('Stream Key')->sortable(),

            BelongsTo::make('Livestream Account', 'livestreamAccount')->sortable(),

            MorphMany::make('Playback IDs', 'playbackIds')->sortable(),

            Boolean::make('Is Active')->sortable(),

            HasMany::make('Stream Targets'),
        ];
    }

    public function cards(Request $request)
    {
        return [];
    }

    public function filters(Request $request)
    {
        return [];
    }

    public function lenses(Request $request)
    {
        return [];
    }

    public function actions(Request $request)
    {
        return [
            (new EnableStream)->canRun(fn() => true),
            (new DisableStream)->canRun(fn() => true),
        ];
    }
}
