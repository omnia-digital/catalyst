<?php

namespace Modules\Jobs\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;
use Sixlive\TextCopy\TextCopy;

class Transaction extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Modules\Jobs\Models\Transaction::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'transaction_id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'transaction_id',
        'invoice_number',
    ];

    public function subtitle()
    {
        return $this->gateway;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            Text::make('Gateway')->sortable(),

            TextCopy::make('Transaction ID')->sortable(),

            TextCopy::make('Payer ID')->onlyOnDetail(),

            BelongsTo::make('User')->sortable(),

            Text::make('Payer Name')->onlyOnDetail(),

            Text::make('Payer Email')->onlyOnDetail(),

            Currency::make('Amount')->sortable(),

            TextCopy::make('Invoice Number')->sortable()->onlyOnDetail(),

            MorphTo::make('Type', 'transactionable'),
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
