<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\VendorOrderController;
use App\Http\Controllers\VendorProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Customer Routes
    Route::middleware(['customer'])->prefix('customer')->name('customer.')->group(function () {
        Route::get('/vendors', [CustomerController::class, 'index'])->name('vendors.index');
        Route::get('/vendors/{vendor}', [CustomerController::class, 'show'])->name('vendors.show');
        Route::get('/menus/{menu}', [CustomerController::class, 'showMenu'])->name('menus.show');

        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/checkout', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    });

    // Vendor Routes
    Route::middleware(['vendor'])->prefix('vendor')->name('vendor.')->group(function () {
        Route::resource('menus', MenuController::class);

        Route::get('/orders/new', [VendorOrderController::class, 'newOrders'])->name('orders.new');
        Route::get('/orders/preparing', [VendorOrderController::class, 'preparingOrders'])->name('orders.preparing');
        Route::get('/orders/completed', [VendorOrderController::class, 'completedOrders'])->name('orders.completed');
        Route::get('/orders/{order}', [VendorOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/verify', [VendorOrderController::class, 'verifyPayment'])->name('orders.verify');
        Route::post('/orders/{order}/reject', [VendorOrderController::class, 'rejectPayment'])->name('orders.reject');
        Route::post('/orders/{order}/complete', [VendorOrderController::class, 'complete'])->name('orders.complete');

        Route::get('/profile', [VendorProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [VendorProfileController::class, 'update'])->name('profile.update');
    });
});
