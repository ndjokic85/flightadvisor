<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Admin\AirportImportRequest;
use App\Jobs\AirportFileProcess;

class AirportImporterController extends Controller
{

    public function import(AirportImportRequest $request)
    {
        dd('test');
        AirportFileProcess::dispatch();
    }
}
