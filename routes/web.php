<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Manager;
use App\Http\Controllers\Staff;

// ── Auth ──────────────────────────────────────────────────
Route::get('/',       [AuthController::class, 'showLogin'])->name('login');
Route::get('/login',  [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Admin (hanya admin) ───────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Produk
    Route::resource('products',   Admin\ProductController::class);
    Route::get('products/export', [Admin\ProductController::class, 'export'])->name('products.export');
    Route::post('products/import', [Admin\ProductController::class, 'import'])->name('products.import');

    // Kategori & Supplier & User
    Route::resource('categories', Admin\CategoryController::class);
    Route::resource('suppliers',  Admin\SupplierController::class);
    Route::resource('users',      Admin\UserController::class);

    // Stok
    Route::prefix('stock')->name('stock.')->group(function () {
        //Route::get('/',        [Admin\StockController::class, 'index'])->name('index');
        Route::get('/history', [Admin\StockController::class, 'history'])->name('history');
        Route::get('/opname',  [Admin\StockOpnameController::class, 'index'])->name('opname');
        Route::post('/opname', [Admin\StockOpnameController::class, 'store'])->name('opname.store');
        Route::get('/{id}',    [Admin\StockController::class, 'show'])->name('show'); // ← tambah
    });

    // Laporan
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/stock',        [Admin\ReportController::class, 'stock'])->name('stock');
        Route::get('/transactions', [Admin\ReportController::class, 'transactions'])->name('transactions');
        Route::get('/activity',     [Admin\ReportController::class, 'activity'])->name('activity');
    });

    // Pengaturan
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/',        [Admin\SettingController::class, 'index'])->name('index');
        Route::put('/',        [Admin\SettingController::class, 'update'])->name('update');
        Route::delete('/logo', [Admin\SettingController::class, 'deleteLogo'])->name('delete-logo');
    });
});

// ── Manager (hanya manager) ───────────────────────────────
Route::prefix('manager')->name('manager.')->middleware(['auth', 'role:manager'])->group(function () {

    Route::get('/dashboard', [Manager\DashboardController::class, 'index'])->name('dashboard');

    // Produk
    Route::get('/products',         [Manager\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create',  [Manager\ProductController::class, 'create'])->name('products.create');
    Route::post('/products',        [Manager\ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}',    [Manager\ProductController::class, 'show'])->name('products.show');

    // Stok
    Route::prefix('stock')->name('stock.')->group(function () {
        //Route::get('/',        [Manager\StockController::class, 'index'])->name('index');
        Route::get('/in',      [Manager\StockController::class, 'createIn'])->name('create-in');
        Route::post('/in',     [Manager\StockController::class, 'storeIn'])->name('store-in');
        Route::get('/out',     [Manager\StockController::class, 'createOut'])->name('create-out');
        Route::post('/out',    [Manager\StockController::class, 'storeOut'])->name('store-out');
        Route::get('/opname',  [Manager\StockController::class, 'opname'])->name('opname');
        Route::post('/opname', [Manager\StockController::class, 'storeOpname'])->name('opname.store');
        Route::get('/{id}',    [Manager\StockController::class, 'show'])->name('show');
        //Route::post('/{id}/confirm', [Manager\StockController::class, 'confirm'])->name('confirm');
        //Route::post('/{id}/reject',  [Manager\StockController::class, 'reject'])->name('reject');
    });

    // Supplier
    Route::get('/suppliers',           [Manager\SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('/suppliers/{supplier}', [Manager\SupplierController::class, 'show'])->name('suppliers.show');

    // Laporan
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/stock',        [Manager\ReportController::class, 'stock'])->name('stock');
        Route::get('/transactions', [Manager\ReportController::class, 'transactions'])->name('transactions');
    });
});

// ── Staff (hanya staff) ───────────────────────────────────
Route::prefix('staff')->name('staff.')->middleware(['auth', 'role:staff'])->group(function () {

    Route::get('/dashboard', [Staff\DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('stock')->name('stock.')->group(function () {
        Route::get('/',              [Staff\StockController::class, 'index'])->name('index');
        Route::post('/{id}/confirm', [Staff\StockController::class, 'confirm'])->name('confirm');
        Route::post('/{id}/reject',  [Staff\StockController::class, 'reject'])->name('reject');
        Route::get('/{id}',          [Staff\StockController::class, 'show'])->name('show');
    });
});


