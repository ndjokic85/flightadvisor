<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\User\CityIndexRequest;
use App\Http\Requests\Api\v1\User\RouteIndexRequest;
use App\Http\Resources\CityResource;
use App\Repositories\ICityRepository;
use Illuminate\Http\Response;

class RouteController extends Controller
{

  /*   private ICityRepository $cityRepository;

    public function __construct(ICityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    } */

    public function index(RouteIndexRequest $request) {

       /*  $cities = $this->cityRepository->all($request->comments_limit);
        return CityResource::collection($cities)
        ->response()
        ->setStatusCode(Response::HTTP_PARTIAL_CONTENT); */
    }
}
