<?php

namespace App\Http\Controllers\Api\v1\User;

use App\FlightAdvisor\Routes\IRoute;
use App\FlightAdvisor\Services\IGraphCreatable;
use App\FlightAdvisor\Services\RouteService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\User\RouteIndexRequest;
use App\Http\Resources\RouteResource;
use App\Models\Route;
use Illuminate\Http\Response;

class RouteController extends Controller
{

  private IRoute $route;
  private IGraphCreatable $graphCreator;
  private RouteService $routeService;

  public function __construct(IGraphCreatable $graphCreator, IRoute $route, RouteService $routeService)
  {
    $this->route = $route;
    $this->graphCreator = $graphCreator;
    $this->routeService = $routeService;
  }

  public function index(RouteIndexRequest $request)
  {
    $graph = $this->graphCreator->create();
    $shortestPath = $this->route->shortestPaths($graph, $request->source, $request->destination);
    $routes  = $this->routeService->collect($shortestPath);
    $data['routes'] = RouteResource::collection($routes);
    $data['total_price'] = $routes->sum('price');
    return response(['data' => $data])->setStatusCode(Response::HTTP_PARTIAL_CONTENT);
  }
}
