<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/sign-up', [AuthController::class, 'signup_view']);
Route::get('/sign-in', [AuthController::class, 'signin_view']);
Route::get('/forgot-password', [AuthController::class, 'forgot_password_view']);
Route::get('/new-password', [AuthController::class, 'new_password_view']);
Route::get('/messages', [MessageController::class, 'index']);
Route::get('/profile', [UsersController::class, 'user_profile_view']);

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
});

Route::prefix('organization')->group(function () {
    Route::get('/profile', [OrganizationsController::class, 'org_profile_view']);
    Route::get('/post-details', [OrganizationsController::class, 'post_details_view']);
});

Route::prefix('admin')->group(function () {
    Route::get('/home', [AdminController::class, 'home_view']);
    Route::get('/messages', [AdminController::class, 'message_view']);
    Route::get('/notifications', [AdminController::class, 'notification_view']);
    Route::get('/profile', [AdminController::class, 'profile_view']);
});

Route::prefix('users')->controller(UsersController::class)->group(function () {
    Route::get('add-new-user', 'new_user_view');
    Route::get('lists', 'users_lists_view');
    Route::get('details/{id}', 'users_details_view');
});
