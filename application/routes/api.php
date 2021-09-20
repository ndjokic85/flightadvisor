<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->namespace('App\Http\Controllers\Api\v1\Admin')->prefix('v1/admin')->group(function () {
    Route::post('/cities', 'CityController@create');
});

Route::namespace('App\Http\Controllers\Api\v1')
    ->prefix('v1')
    ->group(function () {
        Route::post('/users', 'AuthenticationController@create');
        Route::post('/users/login', 'AuthenticationController@login');
    });
