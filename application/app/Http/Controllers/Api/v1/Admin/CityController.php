<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CityController extends Controller
{

    public function __construct()
    {

    }

    public function create(Request $request)
    {
dd('test');
        //return UserResource::make($user->refresh())->response()->setStatusCode(201);
    }
}
