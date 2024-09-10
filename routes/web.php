<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

// Route::post('admin/get_admin_lists', [AdminController::class, 'get_admin_lists']);
