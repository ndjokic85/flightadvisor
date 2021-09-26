<?php

namespace App\Providers;

use App\FlightAdvisor\Routes\Dijkstra;
use App\FlightAdvisor\Routes\IRoute;
use App\FlightAdvisor\Services\GraphCreator;
use App\FlightAdvisor\Services\IGraphCreatable;
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
        $this->app->bind(IRoute::class, Dijkstra::class);
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
