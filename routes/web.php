<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/sign-up', [AuthController::class, 'signup_view']);
Route::get('/sign-in', [AuthController::class, 'signin_view']);
Route::get('/forgot-password', [AuthController::class, 'forgot_password_view']);
Route::get('/new-password', [AuthController::class, 'new_password_view']);

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
});

Route::prefix('users')->controller(UsersController::class)->group(function () {
    Route::get('add-new-user', 'new_user_view');
    Route::get('lists', 'users_lists_view');
    Route::get('details/{id}', 'users_details_view');
});
