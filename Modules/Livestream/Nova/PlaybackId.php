<?php

    namespace Modules\Livestream\Nova;

    use Illuminate\Http\Request;
    use KABBOUCHI\NovaImpersonate\Impersonate;
    use Laravel\Nova\Fields\BelongsTo;
    use Laravel\Nova\Fields\BelongsToMany;
    use Laravel\Nova\Fields\Gravatar;
    use Laravel\Nova\Fields\HasMany;
    use Laravel\Nova\Fields\HasOne;
    use Laravel\Nova\Fields\ID;
    use Laravel\Nova\Fields\Image;
    use Laravel\Nova\Fields\MorphTo;
    use Laravel\Nova\Fields\Password;
    use Laravel\Nova\Fields\Text;

    class PlaybackId extends Resource
    {
        /**
         * The model the resource corresponds to.
         *
         * @var string
         */
        public static $model = \App\Models\PlaybackId::class;


        public static $group = 'Livestream';

        /**
         * The single value that should be used to represent the resource when being displayed.
         *
         * @var string
         */
        public static $title = 'playback_id';

        /**
         * The columns that should be searched.
         *
         * @var array
         */
        public static $search = [
            'playback_id', 'playbackable_id', 'playbackable_type'
        ];

        /**
         * Get the fields displayed by the resource.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return array
         */
        public function fields(Request $request)
        {
            return [
                ID::make()->sortable(),

                Text::make('Playback Id', 'playback_id'),

                Text::make('Policy'),

                MorphTo::make('Playback', 'playbackable'),
            ];
        }

        /**
         * Get the cards available for the request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return array
         */
        public function cards(Request $request)
        {
            return [];
        }

        /**
         * Get the filters available for the resource.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return array
         */
        public function filters(Request $request)
        {
            return [];
        }

        /**
         * Get the lenses available for the resource.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return array
         */
        public function lenses(Request $request)
        {
            return [];
        }

        /**
         * Get the actions available for the resource.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return array
         */
        public function actions(Request $request)
        {
            return [];
        }
    }
