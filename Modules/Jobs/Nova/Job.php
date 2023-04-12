<?php

namespace Modules\Jobs\Nova;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Modules\Jobs\Models\ApplyType;
use Modules\Jobs\Models\PaymentType;

class Job extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Modules\Jobs\Models\JobPosition::class;

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
            ID::make(__('ID'), 'id')->sortable(),

            Text::make('Title')
                ->rules('required', 'max:254')
                ->sortable(),

            Textarea::make('Description')
                ->rules('required')
                ->alwaysShow(),

            BelongsTo::make('Company', 'company', Company::class)
                ->sortable()
                ->exceptOnForms(),

            Select::make('Apply Type')
                ->rules('required', Rule::in(['link', 'email']))
                ->sortable()
                ->displayUsingLabels()
                ->options(ApplyType::pluck('name', 'code')),

            Text::make('Apply Value')
                ->rules('required', 'max:254')
                ->hideFromIndex(),

            Select::make('Payment Type')
                ->rules('required', Rule::in(['hourly', 'fixed']))
                ->sortable()
                ->displayUsingLabels()
                ->options(PaymentType::pluck('name', 'code')),

            Currency::make('Budget')
                ->rules('required', 'numeric')
                ->sortable(),

            Text::make('Location')
                ->rules('required', 'max:254')
                ->sortable(),

            BelongsTo::make('Client', 'client', User::class)
                ->sortable()
                ->exceptOnForms(),

            MorphTo::make('Redeemed Coupon', 'redeemedCoupon')->onlyOnDetail(),

            BelongsToMany::make('JobPositionAddon', 'addons'),
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
