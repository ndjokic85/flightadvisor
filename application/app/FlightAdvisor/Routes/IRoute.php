<?php

namespace App\FlightAdvisor\Routes;

interface IRoute
{
    public function shortestPaths(array $graphArray, $source, $target, array $exclude = array());
}
