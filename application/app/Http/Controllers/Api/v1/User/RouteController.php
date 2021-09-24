<?php

namespace App\Http\Controllers\Api\v1\User;

use App\FlightAdvisor\Routes\IRouteSearchable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\User\RouteIndexRequest;
use App\Repositories\IRouteRepository;

class RouteController extends Controller
{

  private IRouteSearchable $routeSearcher;
  private IRouteRepository $routeRepository;

  public function __construct(IRouteSearchable $routeSearcher, IRouteRepository $routeRepository)
  {
    $this->routeSearcher = $routeSearcher;
    $this->routeRepository = $routeRepository;
  }

  public function index(RouteIndexRequest $request)
  {
    $routesAll = $this->routeRepository->all($request->all());
    $routes = $this->routeSearcher->findCheapestFlight($routesAll->toArray(), 3456, 3421);
  }
}
