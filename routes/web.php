<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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
Route::get('/register', [Controllers\AuthController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [Controllers\AuthController::class, 'register'])->name('register');
Route::get('/login', [Controllers\AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [Controllers\AuthController::class, 'login'])->name('login');
Route::post('/logout', [Controllers\AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // admin
    Route::middleware(['App\Http\Middleware\CheckRole:admin'])->prefix('admin')->name('admin.')->group(function () {

        // dashboard
        Route::get('/dashboard', [Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // wisata
        Route::prefix('wisata')->name('wisata.')->group(function () {
            Route::get('/', [Controllers\Admin\WisataController::class, 'index'])->name('index');
            Route::get('/create', [Controllers\Admin\WisataController::class, 'create'])->name('create');
            Route::post('/store', [Controllers\Admin\WisataController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [Controllers\Admin\WisataController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [Controllers\Admin\WisataController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [Controllers\Admin\WisataController::class, 'destroy'])->name('delete');
        });

        // kategori
        Route::prefix('kategori')->name('kategori.')->group(function () {
            Route::get('/', [Controllers\Admin\KategoriController::class, 'index'])->name('index');
            Route::get('/create', [Controllers\Admin\KategoriController::class, 'create'])->name('create');
            Route::post('/store', [Controllers\Admin\KategoriController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [Controllers\Admin\KategoriController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [Controllers\Admin\KategoriController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [Controllers\Admin\KategoriController::class, 'destroy'])->name('delete');
        });
    });

    // user
    Route::middleware(['App\Http\Middleware\CheckRole:user'])->prefix('user')->name('user.')->group(function () {
        Route::get('/', [Controllers\User\HomeController::class, 'index'])->name('home');
        Route::get('/about', [Controllers\User\AboutController::class, 'index'])->name('about');
        Route::get('/rekomendasi-wisata', [Controllers\User\RekomendasiWisataController::class, 'index'])->name('rekomendasi.wisata');
        Route::get('/rekomendasi-wisata/{slug}', [Controllers\User\RekomendasiWisataController::class, 'filterByCategory'])->name('rekomendasi.wisata.filter');
        Route::get('/wisata/{id}', [Controllers\User\WisataDetailController::class, 'show'])->name('wisata.detail'); 
        Route::post('/wisata/rating', [Controllers\User\WisataDetailController::class, 'store'])->name('wisata.rating.store');
    });
});
