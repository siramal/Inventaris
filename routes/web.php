<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// --- Public Routes ---
// Jika LandingController tidak ada, arahkan '/' ke halaman login
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
});
// --- Admin Group ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Gunakan ini sebagai gantinya:

    Route::prefix('admin/categories')->group(function () {
        Route::get('/', [AdminController::class, 'categories'])->name('admin.categories');
        Route::get('/create', [AdminController::class, 'createCategory'])->name('admin.categories.create');
        Route::post('/', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
        Route::get('/{id}/edit', [AdminController::class, 'editCategory'])->name('admin.categories.edit');
        Route::put('/{id}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
        Route::delete('/{id}', [AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');
    });

    // Items
    Route::get('/operator/items', [ItemController::class, 'operator'])->name('operator.items');
    Route::get('/admin/items', [ItemController::class, 'index'])->name('admin.items');
    Route::get('/admin/items/create', [ItemController::class, 'createItem'])->name('admin.items.create');
    Route::post('/admin/items', [ItemController::class, 'storeItem'])->name('admin.items.store');
    Route::get('/admin/items/{id}/edit', [ItemController::class, 'editItem'])->name('admin.items.edit');
    Route::put('/admin/items/{id}', [ItemController::class, 'updateItem'])->name('admin.items.update');
    Route::get('/admin/items/{id}/lending', [ItemController::class, 'showLending'])->name('admin.items.lending');

    // User Management
    Route::prefix('admin/users')->group(function () {
        // Admin Accounts
        Route::get('/admin', [UserController::class, 'indexAdmin'])->name('admin.users.admin');
        Route::get('/admin/create', [UserController::class, 'createAdmin'])->name('admin.users.admin.create');
        Route::post('/admin', [UserController::class, 'storeAdmin'])->name('admin.users.admin.store');
        Route::get('/admin/{id}/edit', [UserController::class, 'editAdmin'])->name('admin.users.admin.edit');
        Route::put('/admin/{id}', [UserController::class, 'updateAdmin'])->name('admin.users.admin.update');
        Route::delete('/admin/{id}', [UserController::class, 'destroyAdmin'])->name('admin.users.admin.destroy');
        Route::get('/admin/export', [UserController::class, 'exportAdmin'])->name('admin.users.admin.export');

        // Operator Accounts
        Route::get('/operator', [UserController::class, 'indexOperator'])->name('admin.users.operator');
        Route::get('/operator/create', [UserController::class, 'createOperator'])->name('admin.users.operator.create');
        Route::post('/operator', [UserController::class, 'storeOperator'])->name('admin.users.operator.store');
        Route::get('/operator/{id}/edit', [UserController::class, 'editOperator'])->name('admin.users.operator.edit');
        Route::put('/operator/{id}', [UserController::class, 'updateOperator'])->name('admin.users.operator.update');
        Route::delete('/operator/{id}', [UserController::class, 'destroyOperator'])->name('admin.users.operator.destroy');
        Route::patch('/operator/{id}/reset', [UserController::class, 'resetPasswordOperator'])->name('admin.users.operator.reset');
        Route::get('/operator/export', [UserController::class, 'exportOperator'])->name('admin.users.operator.export');
    });
});

// --- Operator Group ---
Route::middleware(['auth', 'role:operator'])->group(function () {
    Route::prefix('operator/lending')->group(function () {
        Route::get('/', [LendingController::class, 'index'])->name('operator.lending.index');
        Route::get('/create', [LendingController::class, 'create'])->name('operator.lending.create');
        Route::post('/', [LendingController::class, 'store'])->name('operator.lending.store');
        Route::patch('/{id}/returned', [LendingController::class, 'markAsReturned'])->name('operator.lending.returned');
        Route::delete('/{id}', [LendingController::class, 'destroy'])->name('operator.lending.destroy');
    });
});

// --- Shared Group ---
Route::middleware(['auth', 'role:admin,operator'])->group(function () {
    Route::get('/items', [ItemController::class, 'index'])->name('shared.items');
});
