<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\AboutController;
use App\Http\Controllers\Admin\WisataController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\WisataDetailController;
use App\Http\Controllers\User\RekomendasiWisataController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// auth
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // admin
    Route::middleware(['App\Http\Middleware\CheckRole:admin'])->prefix('admin')->name('admin.')->group(function () {

        // dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // wisata
        Route::prefix('wisata')->name('wisata.')->group(function () {
            Route::get('/', [WisataController::class, 'index'])->name('index');
            Route::get('/create', [WisataController::class, 'create'])->name('create');
            Route::post('/store', [WisataController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [WisataController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [WisataController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [WisataController::class, 'destroy'])->name('delete');
        });

        // kategori
        Route::prefix('kategori')->name('kategori.')->group(function () {
            Route::get('/', [KategoriController::class, 'index'])->name('index');
            Route::get('/create', [KategoriController::class, 'create'])->name('create');
            Route::post('/store', [KategoriController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [KategoriController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [KategoriController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [KategoriController::class, 'destroy'])->name('delete');
        });
    });

    // user
    Route::middleware(['App\Http\Middleware\CheckRole:user'])->prefix('user')->name('user.')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/about', [AboutController::class, 'index'])->name('about');
        Route::get('/rekomendasi-wisata', [RekomendasiWisataController::class, 'index'])->name('rekomendasi.wisata');
        Route::get('/rekomendasi-wisata/{slug}', [RekomendasiWisataController::class, 'filterByCategory'])->name('rekomendasi.wisata.filter');
        Route::get('/wisata/{id}', [WisataDetailController::class, 'show'])->name('wisata.detail'); 
        Route::post('/wisata/rating', [WisataDetailController::class, 'store'])->name('wisata.rating.store');
    });
});
