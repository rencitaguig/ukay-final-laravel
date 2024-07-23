<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Models\Product;

Route::get('/', function () {
    return view('index');
})->name('home');


Route::view('/customer-all', 'customer.index');
Route::view('/brand-all', 'brand.index');
Route::view('/announcement-all', 'announcement.index');
Route::view('/product-all', 'product.index');


Route::post('/announcements/import', [AnnouncementController::class, 'import']);
Route::post('/brands/import', [BrandController::class, 'import']);
Route::post('/products/import', [ProductController::class, 'import']);

Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('products/fetch', [ProductController::class, 'fetchProducts'])->name('products.fetch');


require __DIR__ . '/auth.php';
