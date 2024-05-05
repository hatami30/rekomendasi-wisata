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

// public
Route::get('/', [Controllers\User\HomeController::class, 'index'])->name('home');
Route::get('/about', [Controllers\User\AboutController::class, 'index'])->name('about');
Route::get('/wisata', [Controllers\User\UserWisataController::class, 'index'])->name('wisata');
Route::get('/wisata/{slug}', [Controllers\User\UserWisataController::class, 'filterByCategory'])->name('wisata.filter');
Route::get('/wisata-bawean/{id}', [Controllers\User\WisataDetailController::class, 'show'])->name('wisata.detail'); 

// auth
Route::get('/register', [Controllers\AuthController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [Controllers\AuthController::class, 'register'])->name('register');
Route::get('/login', [Controllers\AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [Controllers\AuthController::class, 'login'])->name('login');
Route::post('/logout', [Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/forgot', [Controllers\AuthController::class, 'forgotForm'])->name('forgot.form');
Route::post('/forgot', [Controllers\AuthController::class, 'forgotPost'])->name('forgot.post');
Route::get('/reset/{token}', [Controllers\AuthController::class, 'resetForm'])->name('reset.form');
Route::post('/reset/{token}', [Controllers\AuthController::class, 'resetPost'])->name('reset.post');

Route::middleware(['auth'])->group(function () {
    // admin
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {

        // dashboard
        Route::get('/dashboard', [Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // wisata
        Route::prefix('wisata')->name('wisata.')->group(function () {
            Route::get('/', [Controllers\Admin\AdminWisataController::class, 'index'])->name('index');
            Route::get('/create', [Controllers\Admin\AdminWisataController::class, 'create'])->name('create');
            Route::post('/store', [Controllers\Admin\AdminWisataController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [Controllers\Admin\AdminWisataController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [Controllers\Admin\AdminWisataController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [Controllers\Admin\AdminWisataController::class, 'destroy'])->name('delete');
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

        // peringkat
        Route::prefix('perhitungan')->name('perhitungan.')->group(function () {
            Route::get('/', [Controllers\Admin\PeringkatController::class, 'index'])->name('index');
        });

        // perizinan
        Route::prefix('perizinan')->name('perizinan.')->group(function () {
            Route::get('/', [Controllers\Admin\PerizinanController::class, 'index'])->name('index');
            // Route::get('/create', [Controllers\Admin\PerizinanController::class, 'create'])->name('create');
            // Route::post('/store', [Controllers\Admin\PerizinanController::class, 'store'])->name('store');
            // Route::get('/edit/{id}', [Controllers\Admin\PerizinanController::class, 'edit'])->name('edit');
            // Route::put('/update/{id}', [Controllers\Admin\PerizinanController::class, 'update'])->name('update');
            // Route::delete('/delete/{id}', [Controllers\Admin\PerizinanController::class, 'destroy'])->name('delete');
        });
    });

    // user
    Route::middleware(['auth.user'])->group(function () {
        // Route::post('/wisata/rating', [Controllers\User\WisataDetailController::class, 'store'])->name('wisata.rating');
        Route::post('/perhitungan', [Controllers\PerhitunganController::class, 'store'])->name('perhitungan.store');
        // Route::post('/similarities/save', [Controllers\User\WisataDetailController::class, 'saveSimilarities'])->name('similarities.save');
        // Route::post('/predictions/save', [Controllers\User\WisataDetailController::class, 'savePredictions'])->name('predictions.save');
    });
});
