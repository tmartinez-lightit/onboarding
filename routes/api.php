<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Lightit\Backoffice\Users\App\Controllers\DeleteUserController;
use Lightit\Backoffice\Users\App\Controllers\GetUserController;
use Lightit\Backoffice\Users\App\Controllers\ListUserController;
use Lightit\Backoffice\Users\App\Controllers\StoreUserController;
use Lightit\System\City\App\Controllers\ListCityController;
use Lightit\System\City\App\Controllers\UpdateCityController;
use Lightit\System\City\App\Controllers\DeleteCityController;
use Lightit\System\City\App\Controllers\StoreCityController;
use Lightit\System\City\App\Controllers\GetCityController;
use Lightit\System\Airline\App\Controllers\StoreAirlineController;
use Lightit\System\Airline\App\Controllers\ListAirlineController;
use Lightit\System\Airline\App\Controllers\GetAirlineController;
use Lightit\System\Airline\App\Controllers\UpdateAirlineController;
use Lightit\System\Airline\App\Controllers\DeleteAirlineController;
use Lightit\System\Flight\App\Controllers\ListFlightController;
use Lightit\System\Flight\App\Controllers\GetFlightController;
use Lightit\System\Flight\App\Controllers\StoreFlightController;
use Lightit\System\Flight\App\Controllers\UpdateFlightController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Users Routes
|--------------------------------------------------------------------------
*/
Route::prefix('users')
    ->group(static function () {
        Route::get('/', ListUserController::class);
        Route::get('/{user}', GetUserController::class)->withTrashed();
        Route::post('/', StoreUserController::class);
        Route::delete('/{user}', DeleteUserController::class);
    });

/*
|--------------------------------------------------------------------------
| Cities Routes
|--------------------------------------------------------------------------
*/
Route::prefix('cities')
    ->group(static function () {
        Route::post('/', StoreCityController::class);
        Route::get('/', ListCityController::class);
        Route::prefix('{city}')->group(function () {
            Route::get('/', GetCityController::class);
            Route::put('/', UpdateCityController::class);
            Route::delete('/', DeleteCityController::class);
        });
    });

/*
|--------------------------------------------------------------------------
| Airlines Routes
|--------------------------------------------------------------------------
*/
Route::prefix('airlines')
    ->group(static function () {
        Route::post('/', StoreAirlineController::class);
        Route::get('/', ListAirlineController::class);
        Route::prefix('{airline}')->group(function () {
            Route::get('/', GetAirlineController::class);
            Route::put('/', UpdateAirlineController::class);
            Route::delete('/', DeleteAirlineController::class);
        });
    });

/*
|--------------------------------------------------------------------------
| Flights Routes
|--------------------------------------------------------------------------
*/
Route::prefix('flights')
    ->group(static function () {
        Route::post('/', StoreFlightController::class);
        Route::get('/', ListFlightController::class);
        Route::prefix('{flight}')->group(function () {
            Route::get('/', GetFlightController::class);
            Route::put('/', UpdateFlightController::class);
        });
    });
