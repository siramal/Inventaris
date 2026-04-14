<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// --- Public Routes ---
Route::get('/', function () {
    return view('lending');
})->name('landing');
Route::post('/login', [AuthController::class, 'auth'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware(['auth', 'role:operator'])->group(function () {
    // Tambahkan baris ini!
    Route::get('/operator/dashboard', [LendingController::class, 'dashboard'])->name('operator.dashboard');

    Route::prefix('operator/lending')->group(function () {
        // ... rute lending lainnya
    });
});// --- Admin Group (Hanya Admin) ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::prefix('admin/categories')->group(function () {
        Route::get('/', [AdminController::class, 'categories'])->name('admin.categories');
        Route::get('/create', [AdminController::class, 'createCategory'])->name('admin.categories.create');
        Route::post('/', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
        Route::get('/{id}/edit', [AdminController::class, 'editCategory'])->name('admin.categories.edit');
        Route::put('/{id}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
        Route::delete('/{id}', [AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');
    });

    // Items khusus Admin (untuk akses Create/Edit)
    Route::get('/admin/items', [ItemController::class, 'index'])->name('admin.items');
    Route::get('/admin/items/create', [ItemController::class, 'createItem'])->name('admin.items.create');
    Route::post('/admin/items', [ItemController::class, 'storeItem'])->name('admin.items.store');
    Route::get('/admin/items/{id}/edit', [ItemController::class, 'editItem'])->name('admin.items.edit');
    Route::put('/admin/items/{id}', [ItemController::class, 'updateItem'])->name('admin.items.update');
    Route::get('/admin/items/{id}/lending', [ItemController::class, 'showLending'])->name('admin.items.lending');

    // User Management
    Route::prefix('admin/users')->group(function () {
        // ... rute user management admin & operator ...
        Route::get('/admin', [UserController::class, 'indexAdmin'])->name('admin.users.admin');
        Route::get('/operator', [UserController::class, 'indexOperator'])->name('admin.users.operator');
        // (Lanjutkan rute user management lainnya di sini)
    });
});

// --- Operator Group (Hanya Operator) ---
Route::middleware(['auth', 'role:operator'])->group(function () {
    Route::get('/operator/dashboard', [LendingController::class, 'dashboard'])->name('operator.dashboard');

    Route::prefix('operator/lending')->group(function () {
        Route::get('/', [LendingController::class, 'index'])->name('operator.lending.index');
        Route::get('/create', [LendingController::class, 'create'])->name('operator.lending.create');
        Route::post('/', [LendingController::class, 'store'])->name('operator.lending.store');
        Route::patch('/{id}/returned', [LendingController::class, 'markAsReturned'])->name('operator.lending.returned');
        Route::delete('/{id}', [LendingController::class, 'destroy'])->name('operator.lending.destroy');
    });
});
// --- Shared Group (Bisa diakses Admin DAN Operator) ---
Route::middleware(['auth', 'role:admin,operator'])->group(function () {
    Route::get('/operator/items', [ItemController::class, 'index'])->name('operator.items');
    Route::get('/items', [ItemController::class, 'index'])->name('shared.items');
});