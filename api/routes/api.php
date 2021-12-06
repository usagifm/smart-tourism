<?php

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OperatorLoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminRentAreaController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminVehicleController;
use App\Http\Controllers\Admin\AdminVehicleTypeController;
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
    Route::post('/login', [AdminLoginController::class, 'login']);

    Route::group(['middleware' => [
        'auth:sanctum',
        'checkadmin',
    ]], function () {
        Route::get('/', [AdminController::class, 'admin']);
        Route::post('/logout', [AdminLoginController::class, 'logout']);


        Route::group(['prefix' => 'user'], function () {
            Route::get('/all', [AdminUserController::class, 'getUsers']);
            Route::get('/{id}', [AdminUserController::class, 'getUserDetail']);
            Route::get('/{id}/rental/{rental_id}', [AdminUserController::class, 'getUserRentalDetail']);
        });


        Route::group(['prefix' => 'rent-area'], function () {
            Route::get('/all', [AdminRentAreaController::class, 'getRentAreas']);
            Route::post('/add', [AdminRentAreaController::class, 'addRentArea']);
            Route::get('/{id}', [AdminRentAreaController::class, 'detailRentArea']);
            Route::post('/{id}/edit', [AdminRentAreaController::class, 'editRentArea']);
            Route::post('/{id}/delete', [AdminRentAreaController::class, 'deleteRentArea']);
        });

        Route::group(['prefix' => 'vehicle-type'], function () {
            Route::get('/all', [AdminVehicleTypeController::class, 'getVehicleTypes']);
            Route::post('/add', [AdminVehicleTypeController::class, 'addVehicleType']);
            Route::get('/{id}', [AdminVehicleTypeController::class, 'detailVehicleType']);
            Route::post('/{id}/edit', [AdminVehicleTypeController::class, 'editVehicleType']);
            Route::post('/{id}/delete', [AdminVehicleTypeController::class, 'deleteVehicleType']);


            // Vehicle Routes

            Route::get('/vehicle/all', [AdminVehicleController::class, 'getVehicles']);
            Route::get('/vehicle/vehicle-position', [AdminVehicleController::class, 'getVehiclesPosition']);
            Route::post('/{id}/vehicle/add', [AdminVehicleController::class, 'addVehicle']);
            Route::get('/{vehicleTypeId}/vehicle/{id}', [AdminVehicleController::class, 'detailVehicle']);
            Route::post('/{vehicleTypeId}/vehicle/{id}/edit', [AdminVehicleController::class, 'editVehicle']);
            Route::post('/{vehicleTypeId}/vehicle/{id}/delete', [AdminVehicleController::class, 'deleteVehicle']);

        });

    });


});




Route::group(['prefix' => 'vehicle'], function () {

        Route::get('/status/{id}', [VehicleRentalController::class, 'getStatus']);
        Route::post('/status-gmaps/{id}', [VehicleRentalController::class, 'getStatusWithGmaps']);
        Route::post('/send-status/{id}', [VehicleRentalController::class, 'sendTrackHistory']);

});



// });
