<?php

namespace Modules\Jobs\Nova;

use Epartment\NovaDependencyContainer\HasDependencies;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Modules\Jobs\LaraContract;
use Sixlive\TextCopy\TextCopy;

class Coupon extends Resource
{
    use HasDependencies;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Modules\Jobs\Models\Coupon::class;

    public static $with = ['redeems'];

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
        'name',
        'code',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        $types = [
            static::$model::PERCENT => 'Percent',
            static::$model::FIXED => 'Fixed',
        ];

        return [
            ID::make(__('ID'), 'id')->sortable(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:254'),

            TextCopy::make('Code')
                ->rules('nullable', 'max:254', 'unique:coupons,code')
                ->sortable()
                ->hideWhenUpdating()
                ->help('Leave empty if you want a random string.'),

            Select::make('Type')
                ->displayUsingLabels()
                ->options($types)
                ->sortable()
                ->rules('required', Rule::in(array_keys($types))),

            NovaDependencyContainer::make([
                Number::make('Percent', 'discount')
                    ->rules('required', 'min:0', 'max:100', 'numeric')
                    ->displayUsing(fn ($value) => $value . '%'),
            ])->dependsOn('type', static::$model::PERCENT),

            NovaDependencyContainer::make([
                Currency::make('Amount', 'discount')
                    ->rules('required', 'numeric')
                    ->displayUsing(fn ($value) => LaraContract::money($value)),
            ])->dependsOn('type', static::$model::FIXED),

            Text::make('Discount')
                ->displayUsing(fn ($value) => $this->type === static::$model::PERCENT ? $value . '%' : LaraContract::money($value))
                ->onlyOnIndex(),

            DateTime::make('Expires At')->sortable(),

            Text::make('Redeems', fn () => $this->redeems->count())->sortable(),

            HasMany::make('Redeems', 'redeems', RedeemedCoupon::class),
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
