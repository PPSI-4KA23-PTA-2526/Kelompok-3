<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

Route::get('/product', [ProductController::class, 'index'])->name('produk.index');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

Route::get('/antrean', function () {
    return view('pages.antrean');
})->name('antrean');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
// Add this route to your web.php file
