<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MidtransController;

Route::get('/product', [ProductController::class, 'index'])->name('produk.index');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

Route::post('/midtrans/webhook', [MidtransController::class, 'handle']);

Route::get('/antrean', [OrderController::class, 'antrean'])->name('antrean');

// Route untuk API pencarian antrean (opsional, untuk AJAX)
Route::get('/api/antrean/search', [OrderController::class, 'searchAntrean'])->name('orders.antrean.search');

// Route untuk update status (jika diperlukan untuk admin)
Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');

// Add this route to your web.php file
Route::get('/payment/finish', [MidtransController::class, 'finish'])
    ->name('payment.finish');
