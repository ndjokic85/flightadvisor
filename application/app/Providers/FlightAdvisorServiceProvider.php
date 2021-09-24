<?php

namespace App\Providers;

use App\FlightAdvisor\Routes\BreathFirstRouteSearcher;
use App\FlightAdvisor\Routes\IRouteSearchable;
use Illuminate\Support\ServiceProvider;

class FlightAdvisorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IRouteSearchable::class, BreathFirstRouteSearcher::class);
    }
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
