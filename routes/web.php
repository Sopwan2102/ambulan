<?php

use App\Http\Controllers\AmbulansController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;




Route::get('/master', function () {
    return view('layouts.master');
});

//auth
Route::prefix('auth')->group(function () {
    Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/postRegister', [AuthController::class, 'postRegister'])->name('auth.postRegister');
    Route::post('/postlogin', [AuthController::class, 'postlogin'])->name('auth.postlogin');
});

//home
Route::get('/', [HomeController::class, 'index'])->name('home.index');

//ambulan
Route::prefix('ambulan')->group(function () {
    Route::get('/', [AmbulansController::class, 'index'])->name('ambulan.index');
    Route::post('/store', [AmbulansController::class, 'store'])->name('ambulan.store');
    Route::get('/edit/{id}', [AmbulansController::class, 'edit'])->name('ambulan.edit');
    Route::post('/update', [AmbulansController::class, 'update'])->name('ambulan.update');
    Route::delete('/{id}', [AmbulansController::class, 'destroy'])->name('ambulan.destroy');
    Route::get('/detail/{id}', [AmbulansController::class, 'detail'])->name('ambulan.detail');
});

//driver
Route::prefix('driver')->group(function () {
    Route::get('/', [DriverController::class, 'index'])->name('driver.index');
    Route::post('/store', [DriverController::class, 'store'])->name('driver.store');
    Route::get('/edit/{id}', [DriverController::class, 'edit'])->name('driver.edit');
    Route::post('/update', [DriverController::class, 'update'])->name('driver.update');
    Route::delete('/{id}', [DriverController::class, 'destroy'])->name('driver.destroy');
    Route::get('/konfirmasi', [DriverController::class, 'konfirmasi'])->name('driver.konfirmasi');
    Route::post('/approval', [DriverController::class, 'approval'])->name('driver.approval');
});

//dashboard
Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
});

// Lokasi
Route::get('/filter-ambulance', [AmbulansController::class, 'filterByLocation'])->name('ambulan.filterByLocation');