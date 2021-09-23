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

Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::middleware(['auth.admin'])->namespace('App\Http\Controllers\Api\v1\Admin')->prefix('v1/admin')->group(function () {
            Route::post('/cities', 'CityController@create');
            Route::post('/airport-import', 'AirportImporterController@import');
            Route::post('/route-import', 'RouteImporterController@import');
        });

        Route::namespace('App\Http\Controllers\Api\v1\User')->prefix('v1/cities')->group(function () {
            Route::get('/', 'CityController@index');
            Route::post('/{city}/comments', 'CityCommentController@create');
            Route::middleware(['comment.owner'])->group(function () {
                Route::patch('/{city}/comments/{comment}', 'CityCommentController@update');
                Route::delete('/{city}/comments/{comment}', 'CityCommentController@delete');
            });
        });

        Route::namespace('App\Http\Controllers\Api\v1\User')->prefix('v1')->group(function () {
            Route::get('/routes', 'RouteController@index'); 
        });
    });
Route::namespace('App\Http\Controllers\Api\v1')->prefix('v1/users')->group(function () {
    Route::post('/', 'AuthenticationController@create');
    Route::post('/login', 'AuthenticationController@login');
});
