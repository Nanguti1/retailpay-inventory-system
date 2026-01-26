<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockTransferController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::middleware('guest')->group(function (): void {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function (): void {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('transfers', [StockTransferController::class, 'index'])->name('transfers.index');
    Route::get('transfers/create', [StockTransferController::class, 'create'])->name('transfers.create');
    Route::post('transfers', [StockTransferController::class, 'store'])->name('transfers.store');
    Route::post('transfers/{id}/complete', [StockTransferController::class, 'complete'])->name('transfers.complete');
    Route::post('transfers/{id}/cancel', [StockTransferController::class, 'cancel'])->name('transfers.cancel');
});
