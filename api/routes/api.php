<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OperatorLoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Operator\OperatorController;
use App\Http\Controllers\Operator\OpRentalController;
use App\Http\Controllers\Operator\OpVehicleController;
use App\Http\Controllers\User\RentalController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\VehicleController;
use App\Http\Controllers\Vehicle\VehicleRentalController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

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


Route::group(['prefix' => 'user'], function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);

    Route::group(['middleware' => [
        'auth:sanctum',
        'checkuser',
    ]], function () {

        Route::get('/', [UserController::class, 'user']);
        Route::post('/logout', [LoginController::class, 'logout']);

            Route::group(['prefix' => 'vehicle'], function () {
            Route::get('/all', [VehicleController::class, 'getVehicles']);
            Route::get('/{id}', [VehicleController::class, 'getVehicleDetail']);
            Route::post('/{id}/rent', [VehicleController::class, 'rentVehicle']);
            Route::get('/rental/all', [RentalController::class, 'getAllRental']);
            Route::get('/{vehicle_id}/rental/{id}', [RentalController::class, 'getRentalDetail']);
        });

    });


});

Route::group(['prefix' => 'operator'], function () {

    Route::post('/login', [OperatorLoginController::class, 'login']);


    Route::group(['middleware' => [
        'auth:sanctum',
        'checkoperator',
    ]], function () {
        Route::get('/', [OperatorController::class, 'operator']);
        Route::post('/logout', [OperatorLoginController::class, 'logout']);


        Route::group(['prefix' => 'vehicle'], function () {
            Route::get('/all', [OpVehicleController::class, 'getVehicles']);
            Route::get('/{id}', [OpVehicleController::class, 'getVehicleDetail']);
            Route::get('/rental/all', [OpRentalController::class, 'getAllRental']);
            Route::get('/{vehicle_id}/rental/{id}', [OpRentalController::class, 'getRentalDetail']);
            Route::post('/{vehicle_id}/rental/{id}/approve', [OpRentalController::class, 'approveRental']);
            Route::post('/{vehicle_id}/rental/{id}/reject', [OpRentalController::class, 'rejectRental']);
            Route::post('/{vehicle_id}/rental/{id}/end', [OpRentalController::class, 'endRental']);
            Route::post('/{vehicle_id}/rental/{id}/pay', [OpRentalController::class, 'payRental']);
        });
    });
});



Route::group(['prefix' => 'admin'], function () {
    Route::post('/login', [LoginController::class, 'login']);

    Route::group(['middleware' => [
        'auth:sanctum',
        'checkadmin',
    ]], function () {

        Route::get('/', [UserController::class, 'user']);
        Route::post('/logout', [LoginController::class, 'logout']);

            Route::group(['prefix' => 'vehicle'], function () {
        });

    });


});




Route::group(['prefix' => 'vehicle'], function () {

        Route::get('/send/{id}', [VehicleRentalController::class, 'getStatus']);
        Route::get('/gmaps', [VehicleRentalController::class, 'googleMaps']);

});


// });
