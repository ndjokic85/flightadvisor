<?php

namespace App\FlightAdvisor\Routes;

use App\Repositories\IRouteRepository;

class BreathFirstRouteSearcher implements IRouteSearchable
{
    private IRouteRepository $routeRepository;

    public array $routes = [];

    public function __construct(IRouteRepository $routeRepository)
    {
        $this->routeRepository = $routeRepository;
    }

    public function isNotVisited(int $x, array $path): bool
    {
        return true;
    }

    public function findPaths(array $g, int $source, int $destination, int $v)
    {
    }

    public function printPath(array $path)
    {
    }

    public function findCheapestFlight(int $source, int $destinaton): array
    {
        $allRoutes = $this->routeRepository->all();
        return $allRoutes;
    }
}
