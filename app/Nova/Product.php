<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\BelongsTo;
use App\Nova\Filters\ProductBrand;
use App\Nova\Metrics\NewProducts;
use App\Nova\Metrics\AveragePrice;
use App\Nova\Metrics\ProductsPerDay;
// use App\Models\Brand;
use Laravel\Nova\Http\Requests\NovaRequest;

class Product extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Product>
     */
    public static $model = \App\Models\Product::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public function subtitle()
    {
        return "Brand: {$this->brand->name}";
    }

    public static $globalSearchResults = 2;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'sku'
    ];

    public static $clickAction = 'edit';

    public static $tableStyle = 'tight';

    public static $showColumnBorders = true;

    public static $perPageOptions = [ 10, 20, 30, 40, 50];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Slug::make('Slug')
                ->from('name')
                ->required()
                ->textAlign('left')
                ->hideFromIndex()
                ->withMeta(['extraAttributes' => [
                    'readonly' => true
                ]]),
            Text::make('Name')
                ->required()
                ->showOnPreview()
                ->textAlign('left')
                ->placeHolder('Product name...')
                ->sortable(),
            Markdown::make('Description')
                ->required()
                ->showOnPreview()
                ->placeHolder('Product description...'),
            Currency::make('Price')
                ->required()
                ->textAlign('left')
                ->showOnPreview()
                ->sortable()
                ->placeHolder('Product price...'),
            Text::make('Sku')
                ->required()
                ->textAlign('left')
                ->showOnPreview()
                ->sortable()
                ->placeHolder('Product sku...')
                ->help('Number that retailers use to track product'),
            Number::make('Quantity')
                ->required()
                ->textAlign('left')
                ->showOnPreview()
                ->sortable()
                ->placeHolder('Product qunatity...'),
            Boolean::make('Status', 'is_published')
                ->required()
                ->textAlign('left')
                ->sortable()
                ->showOnPreview(),

            BelongsTo::make('Brand')
                ->sortable()
                ->showOnPreview()
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [
            new NewProducts(),
            new AveragePrice(),
            new ProductsPerDay()
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            new ProductBrand()
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
