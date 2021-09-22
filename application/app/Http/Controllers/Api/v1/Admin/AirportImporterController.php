<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\AirportImportRequest;
use App\Jobs\AirportFileProcess;
use App\Repositories\IAirportRepository;
use App\Repositories\ICityRepository;
use App\Validators\IValidator;

class AirportImporterController extends Controller
{

    private IAirportRepository $airPortRepository;
    private ICityRepository $cityRepository;
    private IValidator $validator;

    public function __construct(IAirportRepository $airPortRepository, ICityRepository $cityRepository, IValidator $validator)
    {
        $this->airPortRepository = $airPortRepository;
        $this->cityRepository  = $cityRepository;
        $this->validator = $validator;
    }
    public function import(AirportImportRequest $request)
    {
        $path = $request->file('file')->getRealPath();
        $csvData = array_map('str_getcsv', file($path));
        AirportFileProcess::dispatch($csvData, $this->airPortRepository, $this->cityRepository, $this->validator);
    }
}
