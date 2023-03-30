<?php

namespace Modules\Livestream\Nova;

    use Illuminate\Http\Request;
    use Laravel\Nova\Fields\BelongsTo;
    use Laravel\Nova\Fields\BelongsToMany;
    use Laravel\Nova\Fields\HasManyThrough;
    use Laravel\Nova\Fields\ID;
    use Laravel\Nova\Fields\Number;
    use Laravel\Nova\Fields\Text;
    use Laravel\Nova\Fields\Textarea;
    use Modules\Livestream\Nova\Actions\AddAttachmentDownloadCount;
    use Modules\Livestream\Nova\Actions\ReplaceEpisodeShortcodesAction;
    use Modules\Livestream\Nova\Filters\EpisodeTeam;

    class Episode extends Resource
    {
        /**
         * The model the resource corresponds to.
         *
         * @var string
         */
        public static $model = \App\Models\Episode::class;

        public static $group = 'Livestream';

        /**
         * The single value that should be used to represent the resource when being displayed.
         *
         * @var string
         */
        public static $title = 'title';

        /**
         * The columns that should be searched.
         *
         * @var array
         */
        public static $search = [
            'title',
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

                Text::make('title'),

                Textarea::make('description'),

                Number::make('Download Count', function () {
                    return $this->attachmentDownloads()->sum('count');
                })->sortable(),

                BelongsTo::make('Category'),

                HasManyThrough::make('Attachment Downloads', 'attachmentDownloads', Download::class),

                BelongsToMany::make('Series', 'series', Series::class),
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
            return [
                new EpisodeTeam,
            ];
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
            return [
                new ReplaceEpisodeShortcodesAction,
                new AddAttachmentDownloadCount,
            ];
        }
    }
