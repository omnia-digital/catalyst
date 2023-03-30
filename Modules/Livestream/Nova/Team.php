<?php

namespace Modules\Livestream\Nova;

    use Illuminate\Http\Request;
    use Laravel\Nova\Fields\BelongsTo;
    use Laravel\Nova\Fields\BelongsToMany;
    use Laravel\Nova\Fields\Boolean;
    use Laravel\Nova\Fields\DateTime;
    use Laravel\Nova\Fields\HasMany;
    use Laravel\Nova\Fields\HasOne;
    use Laravel\Nova\Fields\ID;
    use Laravel\Nova\Fields\Text;

    class Team extends Resource
    {
        /**
         * The model the resource corresponds to.
         *
         * @var string
         */
        public static $model = \App\Models\Team::class;

        public static $group = 'People';

        /**
         * The single value that should be used to represent the resource when being displayed.
         *
         * @var string
         */
        public static $title = 'name';

        /**
         * The columns that should be searched.
         *
         * @var array
         */
        public static $search = [
            'id', 'name',
        ];

        /**
         * The relationship columns that should be searched.
         *
         * @var array
         */
        public static $searchRelations = [
            'users.person' => ['first_name', 'last_name'],
            'users' => ['email'],
        ];

        /**
         * Get the fields displayed by the resource.
         *
         * @return array
         */
        public function fields(Request $request)
        {
            return [
                ID::make()->sortable(),

                Text::make('Livestream ID', function () {
                    return $this->livestreamAccount?->id;
                }),

                HasOne::make('Livestream Account', 'livestreamAccount'),

                Text::make('Name'),

                DateTime::make('Trial Ends At'),

                Boolean::make('Personal Team'),

                BelongsTo::make('Owner', 'owner', User::class),

                HasMany::make('Extra Invoice Items', 'extraInvoiceItems'),

                BelongsToMany::make('Users'),
            ];
        }

        /**
         * Get the cards available for the request.
         *
         * @return array
         */
        public function cards(Request $request)
        {
            return [];
        }

        /**
         * Get the filters available for the resource.
         *
         * @return array
         */
        public function filters(Request $request)
        {
            return [];
        }

        /**
         * Get the lenses available for the resource.
         *
         * @return array
         */
        public function lenses(Request $request)
        {
            return [];
        }

        /**
         * Get the actions available for the resource.
         *
         * @return array
         */
        public function actions(Request $request)
        {
            return [];
        }
    }
