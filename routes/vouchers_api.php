<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VouchersController;

Route::post('apply_voucher', [VouchersController::class, 'apply_voucher']);
