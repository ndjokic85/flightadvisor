<?php

namespace App\FlightAdvisor\Services;

use App\Repositories\IRouteRepository;
use Illuminate\Support\Collection;

class RouteService
{
    private IRouteRepository $routeRepository;

    public function __construct(IRouteRepository $routeRepository)
    {
        $this->routeRepository = $routeRepository;
    }

    public function collect(array $routes): ?Collection
    {
        $collections = collect();
        foreach ($routes as $key => $route) {
            $values = array_values($route);
            for ($i = 0; $i < count($values) - 1; $i++) {
                $model = $this->routeRepository->findBySourceAndDestination($route[$i], $route[$i + 1]);
                $collections->push($model);
            }
        }
        return $collections;
    }
}
