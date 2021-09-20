<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\CityPostRequest;
use App\Repositories\ICityRepository;

class CityController extends Controller
{

    private ICityRepository $cityRepository;
    public function __construct(ICityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function create(CityPostRequest $request)
    {
        $this->cityRepository->create($request->validate());
        //return UserResource::make($user->refresh())->response()->setStatusCode(201);
    }
}
