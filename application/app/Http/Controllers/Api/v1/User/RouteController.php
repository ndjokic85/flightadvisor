<?php

namespace App\Http\Controllers\Api\v1\User;

use App\FlightAdvisor\Routes\IRoute;
use App\FlightAdvisor\Services\RouteService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\User\RouteIndexRequest;
use App\Http\Resources\RouteResource;
use App\Repositories\IRouteRepository;
use Illuminate\Http\Response;

class RouteController extends Controller
{

  private IRoute $route;
  private RouteService $routeService;
  private IRouteRepository $routeRepository;

  public function __construct(IRoute $route, RouteService $routeService, IRouteRepository $routeRepository)
  {
    $this->route = $route;
    $this->routeService = $routeService;
    $this->routeRepository = $routeRepository;
  }

  public function index(RouteIndexRequest $request)
  {
    $graph = $this->routeRepository->allGrouppedBySourceAirport();
    $shortestPath = $this->route->shortestPaths($graph, $request->source, $request->destination);
    $routes  = $this->routeService->collect($shortestPath);
    $data['routes'] = RouteResource::collection($routes);
    $data['total_price'] = $routes->sum('price');
    return response(['data' => $data])->setStatusCode(Response::HTTP_PARTIAL_CONTENT);
  }
}
