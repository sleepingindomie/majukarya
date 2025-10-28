<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\VendorItemController;
use App\Http\Controllers\Api\ReportController;

// Public routes (no authentication required)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (authentication required)
Route::middleware('auth:api')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // CRUD routes for Vendor
    Route::apiResource('vendors', VendorController::class);

    // CRUD routes for Item
    Route::apiResource('items', ItemController::class);

    // CRUD routes for Order
    Route::apiResource('orders', OrderController::class);

    // CRUD routes for VendorItem (untuk manage harga item per vendor)
    Route::apiResource('vendor-items', VendorItemController::class);

    // Report routes
    Route::get('/reports/vendor-items', [ReportController::class, 'vendorItems']);
    Route::get('/reports/vendor-ranking', [ReportController::class, 'vendorRanking']);
    Route::get('/reports/price-rate', [ReportController::class, 'priceRate']);
});
