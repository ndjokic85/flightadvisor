<?php

namespace App\Http\Controllers\Api\v1\User;

use App\FlightAdvisor\Routes\IRoute;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\User\RouteIndexRequest;
use App\Repositories\IRouteRepository;

class RouteController extends Controller
{

  private IRouteRepository $routeRepository;
  private IRoute $route;

  public function __construct(IRouteRepository $routeRepository, IRoute $route)
  {
    $this->routeRepository = $routeRepository;
    $this->route = $route;
  }

  public function index(RouteIndexRequest $request)
  {
    $routesAll = $this->routeRepository->all($request->all());
    $graph = array(
      'zr' => array('bg' => 100, 'ns' => 100),
      'bg' => array('zr' => 100, 'ns' => 1, 'nis' => 50),
      'nis' => array('ns' => 100)
    );
    $routes = $this->route->shortestPaths($graph, 'zr', 'nis');
  }
}
