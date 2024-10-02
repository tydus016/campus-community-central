<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DashboardController;

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
});

Route::prefix('users')->controller(UsersController::class)->group(function () {
    Route::get('add-new-user', 'new_user_view');
    Route::get('lists', 'users_lists_view');
    Route::get('details/{id}', 'users_details_view');
});
