<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\RouteImportRequest;
use App\Jobs\RouteFileProcess;
use App\Repositories\IAirportRepository;
use App\Repositories\ICityRepository;
use App\Repositories\IRouteRepository;
use App\Validators\IValidator;

class RouteImporterController extends Controller
{

    private IAirportRepository $airPortRepository;
    private IRouteRepository $routeRepository;
    private IValidator $validator;

    public function __construct(IAirportRepository $airPortRepository, IRouteRepository $routeRepository, IValidator $validator)
    {
        $this->airPortRepository = $airPortRepository;
        $this->routeRepository = $routeRepository;
        $this->validator = $validator;
    }
    public function import(RouteImportRequest $request)
    {
        $path = $request->file('file')->getRealPath();
        $csvData = array_map('str_getcsv', file($path));
        RouteFileProcess::dispatch($csvData, $this->airPortRepository, $this->routeRepository, $this->validator);
    }
}
