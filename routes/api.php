<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TrackerController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// - admin routes
Route::prefix('admin')->group(function () {
    Route::post('get_admin_lists', [AdminController::class, 'get_admin_lists']);
    Route::post('add_new_admin', [AdminController::class, 'add_new_admin']);
    Route::post('update_admin_profile', [AdminController::class, 'update_admin_profile']);
    Route::post('get_admin_details', [AdminController::class, 'get_admin_details']);
});

// - driver routes
Route::prefix('driver')->group(function () {
    Route::post('get_drivers', [DriverController::class, 'get_drivers']);
    Route::post('add_new_driver', [DriverController::class, 'add_new_driver']);
    Route::post('update_driver_status', [DriverController::class, 'update_driver_status']);
    Route::post('update_driver_delete_status', [DriverController::class, 'update_driver_delete_status']);
    Route::post('update_driver_details', [DriverController::class, 'update_driver_details']);
    Route::post('get_driver_details', [DriverController::class, 'get_driver_details']);
});

// - login route
Route::post('/login/auth_v2', [LoginController::class, 'auth_v2']);

// - tracker routes
Route::prefix('tracker')->group(function () {
    Route::post('create_geofence', [TrackerController::class, 'create_geofence']);
    Route::post('get_active_fence', [TrackerController::class, 'get_active_fence']);
    Route::post('get_geofence_lists', [TrackerController::class, 'get_geofence_lists']);
});
