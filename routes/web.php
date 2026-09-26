<?php

use App\Http\Controllers\CorporateController;
use App\Http\Controllers\CustomBoxBuilderController;
use App\Http\Controllers\GiftBoxController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('gift-boxes')->name('gift-boxes.')->group(function () {
    Route::get('/', [GiftBoxController::class, 'index'])->name('index');
    Route::get('/{slug}', [GiftBoxController::class, 'show'])->name('show');
});

Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/{slug}', [ProductController::class, 'show'])->name('show');
});

Route::get('/custom-box-builder', [CustomBoxBuilderController::class, 'index'])->name('custom-box-builder');
Route::get('/api/builder/products', [CustomBoxBuilderController::class, 'products'])->name('builder.products');

Route::post('/orders', [OrderController::class, 'store'])
    ->name('orders.store')
    ->middleware('throttle:10,1');

Route::get('/orders/{orderNumber}/confirmation', [OrderController::class, 'confirmation'])->name('orders.confirmation');

Route::post('/reviews', [ReviewController::class, 'store'])
    ->name('reviews.store')
    ->middleware('throttle:5,1');

Route::prefix('corporate')->name('corporate.')->group(function () {
    Route::get('/', [CorporateController::class, 'index'])->name('index');
    Route::post('/inquiry', [CorporateController::class, 'store'])
        ->name('inquiry.store')
        ->middleware('throttle:5,1');
});

Route::view('/cart', 'cart')->name('cart');
Route::view('/favorites', 'favorites')->name('favorites');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
