<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Authentication Routes - hanya untuk guest (belum login)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout - harus login dulu
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes - harus login
Route::middleware(['auth'])->group(function () {
    // Home - hanya satu route dengan nama 'home'
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Categories dengan routes manual
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/export', [CategoryController::class, 'export'])->name('export');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');

        // Trash routes - harus sebelum {category} agar tidak konflik
        Route::get('/trash', [CategoryController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id}', [CategoryController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id}', [CategoryController::class, 'deletePermanent'])->name('delete-permanent');

        Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::get('/export', [TransactionController::class, 'export'])->name('export');
        Route::get('/create', [TransactionController::class, 'create'])->name('create');
        Route::post('/store', [TransactionController::class, 'store'])->name('store');
        Route::get('/{transaction}', [TransactionController::class, 'show'])->name('show'); // {transaction} bukan {id}
        Route::get('/{transaction}/edit', [TransactionController::class, 'edit'])->name('edit'); // {transaction}/edit
        Route::put('/{transaction}', [TransactionController::class, 'update'])->name('update'); // {transaction}
        Route::delete('/{transaction}', [TransactionController::class, 'destroy'])->name('destroy'); // {transaction}
        Route::get('/{transaction}/export-pdf', [TransactionController::class, 'eksporPdf'])->name('export_pdf'); // {transaction}
    });

    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::get('/password', [ProfileController::class, 'showPasswordForm'])->name('password');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    });
});