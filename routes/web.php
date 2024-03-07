<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\WisataController;
use App\Http\Controllers\Admin\DashboardController;

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

// landing page
Route::get('/', function () {
    return view('home');
});

// auth
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth'])->group(function () {
    // admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/wisata', [WisataController::class, 'index'])->name('wisata.index');
        Route::get('/wisata/create', [WisataController::class, 'create'])->name('wisata.create');
        Route::post('/wisata/store', [WisataController::class, 'store'])->name('wisata.store');
        Route::get('/wisata/edit/{id}', [WisataController::class, 'edit'])->name('wisata.edit');
        Route::post('/wisata/update/{id}', [WisataController::class, 'update'])->name('wisata.update');
        Route::delete('/wisata/delete/{id}', [WisataController::class, 'destroy'])->name('wisata.delete');
    });

    // user
});
