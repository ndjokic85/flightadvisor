<?php

namespace App\FlightAdvisor\Routes;

interface IRouteSearchable
{
    public function findPaths(array $routes, int $source, int $destination): array;
    public function findCheapestFlight(array $routes, int $source, int $destination): array;
}
