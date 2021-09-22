<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\CityPostRequest;
use App\Http\Resources\CityResource;
use App\Repositories\ICityRepository;
use Symfony\Component\HttpFoundation\Response;

class CityController extends Controller
{
    private ICityRepository $cityRepository;

    public function __construct(ICityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function create(CityPostRequest $request)
    {
        $city = $this->cityRepository->create($request->validated());
        return CityResource::make($city->refresh())->response()->setStatusCode(Response::HTTP_CREATED);;
    }
}
