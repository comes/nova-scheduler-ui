<?php namespace Comes\NovaSchedulerUi;

use Illuminate\Support\Facades\Log;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Console\Scheduling\Event;

class SchedulerExpression extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'scheduler-expression';

    /**
     * Set the hues that may be selected by the color picker.
     *
     * @param Event $event
     * @return $this
     */
    public function event(Event $event)
    {
        return $this->withMeta(['event' => $event]);
    }

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  string  $requestAttribute
     * @param  object  $model
     * @param  string  $attribute
     * @return void
     */
    protected function fillAttributeFromRequest(NovaRequest $request,
                                                $requestAttribute,
                                                $model,
                                                $attribute)
    {
        if ($request->exists($requestAttribute)) {
            $model->{$attribute} = ['cron' => [$request[$requestAttribute]]];
        }
    }
}
