<?php

namespace Modules\Jobs\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;
use Sixlive\TextCopy\TextCopy;

class RedeemedCoupon extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Modules\Jobs\Models\RedeemedCoupon::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'code';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'code',
    ];

    public static $globallySearchable = false;

    public static $displayInNavigation = false;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            BelongsTo::make('Coupon')->sortable(),

            MorphTo::make('Model')->sortable(),

            TextCopy::make('Code')->sortable(),

            Text::make('Type', 'type', fn ($value) => ucfirst($value))->sortable(),

            Currency::make('Original Price')->sortable(),

            Currency::make('Discount Amount')->sortable(),

            Currency::make('After Discount Price')->onlyOnDetail(),

            Date::make('Redeemed At')->sortable(),
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
