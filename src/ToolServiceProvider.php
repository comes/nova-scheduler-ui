<?php

namespace Comes\NovaSchedulerUi;

use Comes\NovaSchedulerUi\Resources\ScheduledCommandResource;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Comes\NovaSchedulerUi\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'nova-scheduler-ui');

        Nova::resources([
            ScheduledCommandResource::class
        ]);

        Nova::serving(function (ServingNova $event) {
            Nova::script('scheduler-expression', __DIR__.'/../dist/js/field.js');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
