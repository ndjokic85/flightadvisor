<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\User\CityIndexRequest;
use App\Http\Resources\CityResource;
use App\Repositories\ICityRepository;
use Illuminate\Http\Response;

class CityController extends Controller
{

    private ICityRepository $cityRepository;

    public function __construct(ICityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function index(CityIndexRequest $request) {

        $cities = $this->cityRepository->all($request->all());
        return CityResource::collection($cities)
        ->response()
        ->setStatusCode(Response::HTTP_PARTIAL_CONTENT);
    }
}
