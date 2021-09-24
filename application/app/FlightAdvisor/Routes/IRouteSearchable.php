<?php

namespace App\FlightAdvisor\Routes;

interface IRouteSearchable
{
    public function findCheapestFlight(int $source, int $destination): array;
}
