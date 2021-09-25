<?php

namespace App\FlightAdvisor\Services;

use App\Repositories\IRouteRepository;

class GraphCreator implements IGraphCreatable
{
    private IRouteRepository $routeRepository;

    private array $routes;

    public function __construct(IRouteRepository $routeRepository)
    {
        $this->routeRepository = $routeRepository;
        $this->routes = $this->routeRepository->allGrouppedBy('source_airport_id')->toArray();
    }
    public function create(): array
    {
        $graph = [];
        foreach ($this->routes as $key => $route) {
            $elements = [];
            foreach ($route as $element) {
                $elements += [$element['destination_airport_id'] => $element['price']];
            }
            $graph[$key] = $elements;
        }
        return $graph;
    }
}
