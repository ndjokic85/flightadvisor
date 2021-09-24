<?php

namespace App\FlightAdvisor\Routes;

use App\Repositories\IRouteRepository;

class BreathFirstRouteSearcher implements IRouteSearchable
{

    public array $routes = [];

    private function isNotVisited(int $x, array $path): bool
    {
        return true;
    }

    public function findPaths(array $routes, int $source, int $destination): array
    {
        return [];
    }

    private function printPath(array $path)
    {
    }

    public function findCheapestFlight(array $routes, int $source, int $destinaton): array
    {
        return [];
    }
}
