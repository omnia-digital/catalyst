<?php

    namespace App\Nova;

    use Illuminate\Http\Request;
    use Laravel\Nova\Fields\BelongsTo;
    use Laravel\Nova\Fields\HasMany;
    use Laravel\Nova\Fields\HasManyThrough;
    use Laravel\Nova\Fields\ID;
    use Laravel\Nova\Fields\Text;

    class LivestreamAccount extends Resource
    {
        /**
         * The model the resource corresponds to.
         *
         * @var string
         */
        public static $model = \App\Models\LivestreamAccount::class;

        public static $group = 'Livestream';

        /**
         * The single value that should be used to represent the resource when being displayed.
         *
         * @var string
         */
        public static $title = 'name';

        public function subtitle()
        {
            return $this->admin_email;
        }

        /**
         * The columns that should be searched.
         *
         * @var array
         */
        public static $search = [
            'name'
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

                Text::make('Team Name', function () {
                    return $this->team->name;
                }),

                BelongsTo::make('Team'),

                HasMany::make('Episodes'),

                HasMany::make('Episode Templates', 'episodeTemplates', EpisodeTemplate::class),

                HasMany::make('Players'),

                HasMany::make('Streams'),

                HasMany::make('Channels'),
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
