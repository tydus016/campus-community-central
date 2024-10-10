<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\VouchersController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrganizationsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// - products routes
Route::prefix('products')->group(function () {
    Route::post('products_lists', [ProductsController::class, 'products_lists']);
    Route::post('product_detail', [ProductsController::class, 'product_detail']);
});

// - vouchers routes
Route::prefix('vouchers')->group(function () {
    Route::post('apply_voucher', [VouchersController::class, 'apply_voucher']);
});

// - orders routes
Route::prefix('orders')->group(function () {
    Route::post('create_order', [OrdersController::class, 'create_order']);
    Route::post('save_order', [OrdersController::class, 'save_order']);
    Route::post('update_order_status', [OrdersController::class, 'update_order_status']);
    Route::post('checkout_order', [OrdersController::class, 'checkout_order']);
});

// - categories routes
Route::prefix('categories')->group(function () {
    Route::post('categories_lists', [CategoriesController::class, 'categories_lists']);
});

// - users routes
Route::prefix('users')->group(function () {
    Route::post('create_user', [UsersController::class, 'create_user']);
    Route::post('users_lists', [UsersController::class, 'users_lists']);
    Route::post('users_details', [UsersController::class, 'users_details']);
    Route::post('update_user_status', [UsersController::class, 'update_user_status']);
    Route::post('update_delete_flg', [UsersController::class, 'update_delete_flg']);
    Route::post('update_user_details', [UsersController::class, 'update_user_details']);
});

// - login routes
Route::prefix('login')->group(function () {
    Route::post('authenticate', [LoginController::class, 'authenticate']);
});

Route::prefix('organization')->controller(OrganizationsController::class)->group(function () {
    Route::post('organizations-lists', 'organizations_lists');
});
