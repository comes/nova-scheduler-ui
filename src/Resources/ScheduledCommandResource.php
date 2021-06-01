<?php

namespace Comes\NovaSchedulerUi\Resources;

use Comes\NovaSchedulerUi\SchedulerArgument;
use Comes\NovaSchedulerUi\SchedulerExpression;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use Vendor\Acme\Acme;

class ScheduledCommandResource extends Resource
{

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \DionTech\Scheduler\Models\ScheduledCommand::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    public static $searchable = false;

    public static $displayInNavigation = false;
    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $event = optional($this->model())->event();
        return [
            ID::make(__('ID'), 'id')->sortable(),

            SchedulerArgument::make(__('Arguments'), 'arguments')->required(),

            Boolean::make(__('Active'), 'is_active')->default(function() {
                return false;
            })->rules('boolean')->required(),

            Textarea::make(__('Description'), 'description'),

            SchedulerExpression::make(__('Fluent'), 'fluent')
                ->required()
                ->event($event),
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


    public static function label()
    {
        return __('Scheduler');
    }
}
