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
    use Laravel\Nova\Fields\Password;
    use Laravel\Nova\Fields\Text;

    class Player extends Resource
    {
        /**
         * The model the resource corresponds to.
         *
         * @var string
         */
        public static $model = \App\Models\Player::class;

        public static $group = 'Livestream';

        /**
         * The single value that should be used to represent the resource when being displayed.
         *
         * @var string
         */
        public static $title = 'id';

        /**
         * The columns that should be searched.
         *
         * @var array
         */
        public static $search = [
            'id',
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
