<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('customers', CustomerController::class);
Route::apiResource('brands', BrandController::class);
Route::apiResource('announcements', AnnouncementController::class);
Route::apiResource('products', ProductController::class);

Route::post('/announcements/import', [AnnouncementController::class, 'import']);
Route::post('/brands/import', [BrandController::class, 'import']);
Route::post('/products/import', [ProductController::class, 'import']);
Route::get('/api/products', [ProductController::class, 'index']);

