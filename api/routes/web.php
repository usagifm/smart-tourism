<?php

use App\Http\Controllers\Auth\WebLoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ManageAdminController;
use App\Http\Controllers\Web\ManageOperatorController;
use App\Http\Controllers\Web\ManageUserController;
use App\Http\Controllers\Web\RentAreaController;
use App\Http\Controllers\Web\StatisticController as WebStatisticController;
use App\Http\Controllers\Web\User\LoginController;
use App\Http\Controllers\Web\User\ProfileController as UserProfileController;
use App\Http\Controllers\Web\User\RegisterController;
use App\Http\Controllers\Web\User\VehicleController;
use App\Http\Controllers\Web\VehicleController as WebVehicleController;
use App\Http\Controllers\Web\VehicleTypeController;
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

// Authentication Admin
Route::get('admin/login', [WebLoginController::class, 'showLoginForm'])->name('login');
Route::post('admin/login', [WebLoginController::class, 'login'])->name('login.post');
Route::post('admin/logout', [WebLoginController::class, 'logout'])->name('logout');


// Authentication User
Route::get('login',     [LoginController::class, 'showLoginForm'])->name('login.user');
Route::post('login',     [LoginController::class, 'login'])->name('login.user.post');
Route::post('logout', [LoginController::class, 'logout'])->name('logout.user');
Route::get('register',  [RegisterController::class, 'showRegistrationForm'])->name('register.user');
Route::post('register',  [RegisterController::class, 'register'])->name('register.user.post');

Route::middleware(['auth:admin', 'admin'])->group(function () {
    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

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
    Route::post('manage/operator/{operator}',        [ManageOperatorController::class, 'resetToken'])->name('manage.operator.resetToken');

    Route::resource('manage/admin',     ManageAdminController::class)
        ->except(['show'])
        ->parameters([
            'admin' => 'admin'
        ]);
});

Route::middleware('auth')->group(function () {
    Route::get('vehicle/rent',      [VehicleController::class, 'create'])->name('dashboard');
    Route::post('vehicle/rent',      [VehicleController::class, 'store'])->name('vehicle.rent.post');
    Route::get('vehicle/history',   [VehicleController::class, 'history'])->name('vehicle.history');
    Route::get('vehicle/invoices/{invoice}',   [VehicleController::class, 'invoices'])->name('vehicle.invoice');

    Route::get('user', [UserProfileController::class, 'show'])->name('profile.user.show');
    Route::put('user', [UserProfileController::class, 'update'])->name('profile.user.update');
});
