<?php

use App\Http\Controllers\Auth\WebLoginController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ManageAdminController;
use App\Http\Controllers\Web\ManageOperatorController;
use App\Http\Controllers\Web\ManageUserController;
use App\Http\Controllers\Web\RentAreaController;
use App\Http\Controllers\Web\StatisticController as WebStatisticController;
use App\Http\Controllers\Web\VehicleController as WebVehicleController;
use App\Http\Controllers\Web\VehicleTypeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/login');

Route::get('login', [WebLoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [WebLoginController::class, 'login'])->name('login.post');

Route::post('logout', [WebLoginController::class, 'logout'])->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware('auth:admin')->group(function () {
    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    Route::get('vehicles/{vehicle}/download',   [WebVehicleController::class, 'download'])->name('vehicles.download');
    Route::resource('vehicles', WebVehicleController::class)->except('show');

    Route::resource('vehicleType', VehicleTypeController::class)->except('show');

    Route::resource('rentarea', RentAreaController::class)
        ->except('show')
        ->parameters([
            'rentarea' => 'rentArea'
        ]);

    Route::get('statistik/penyewaan', [WebStatisticController::class, 'rent'])->name('statistic.rent');
    Route::get('statistik/pendapatan', [WebStatisticController::class, 'revenue'])->name('statistic.revenue');

    Route::get('manage/user',                       [ManageUserController::class, 'index'])->name('manage.user.index');
    Route::post('manage/user/{user}',               [ManageUserController::class, 'resetToken'])->name('manage.user.resetToken');

    Route::get('manage/operator',                   [ManageOperatorController::class, 'index'])->name('manage.operator.index');
    Route::get('manage/operator/{operator}',        [ManageOperatorController::class, 'resetToken'])->name('manage.operator.resetToken');

    Route::resource('manage/admin',     ManageAdminController::class)
        ->except(['show'])
        ->parameters([
            'admin' => 'admin'
        ]);
});
