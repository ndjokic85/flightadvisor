<?php

namespace App\Http\Controllers\Api\v1\User;

use App\FlightAdvisor\Routes\IRouteSearchable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\User\RouteIndexRequest;

class RouteController extends Controller
{

  private IRouteSearchable $routeSearcher;

  public function __construct(IRouteSearchable $routeSearcher)
  {
    $this->routeSearcher = $routeSearcher;
  }

  public function index(RouteIndexRequest $request)
  {
    $routes = $this->routeSearcher->findCheapestFlight(234, 456);
  }
}
