<?php namespace Comes\NovaSchedulerUi;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Console\Scheduling\Event;

class SchedulerArgument extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'scheduler-argument';

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
            $data = json_decode($request[$requestAttribute],true);
            $isJob = is_string($data[1]);

            $validator = Validator::make($data, [
                0 => 'required|min:1',
                1 => $isJob?'required':'sometimes|array',
            ])->validate();

            $model->method = $isJob?'job':'command';
            $model->{$attribute} = $data;
        }
    }

}
