<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\BibController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\User\CheckOrderController;
use App\Http\Controllers\User\RegistrasiController;

// Landing Page
Route::view('/', 'user.landing')->name('home');

// Registrasi Routes
Route::prefix('registrasi')->group(function () {
    Route::get('/', [RegistrasiController::class, 'index'])->name('registrasi.index');

    // Wilayah Indonesia API
    Route::get('/provinces', [RegistrasiController::class, 'getProvinces']);
    Route::get('/cities/{provinceId}', [RegistrasiController::class, 'getCities']);
    Route::get('/districts/{cityId}', [RegistrasiController::class, 'getDistricts']);
    Route::get('/villages/{districtId}', [RegistrasiController::class, 'getVillages']);

    // Form Steps
    Route::post('/step1', [RegistrasiController::class, 'saveStep1'])->name('registrasi.step1');
    Route::post('/step2', [RegistrasiController::class, 'saveStep2'])->name('registrasi.step2');
    Route::post('/step3', [RegistrasiController::class, 'saveStep3'])->name('registrasi.step3');
});

// Payment Routes
Route::prefix('payment')->group(function () {
    Route::get('/finish', [PaymentController::class, 'finish'])->name('payment.finish');
    Route::get('/unfinish', [PaymentController::class, 'unfinish'])->name('payment.unfinish');
    Route::get('/error', [PaymentController::class, 'error'])->name('payment.error');
    Route::post('/notification', [PaymentController::class, 'notification'])->name('payment.notification');

    Route::post('/{id}/update-status', [PaymentController::class, 'updateStatus'])->name('payment.updateStatus');
    Route::get('/{id}', [PaymentController::class, 'show'])->name('payment.show');
});

Route::get('/check-order', [CheckOrderController::class, 'index'])->name('check-order.index');
Route::get('/bib/{peserta}', [BibController::class, 'show'])->name('bib.show');

// Admin Routes
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    // Auth Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected Admin Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Size Management Routes
        Route::get('/sizes', [SizeController::class, 'index'])->name('sizes.index');
        Route::post('/sizes', [SizeController::class, 'store'])->name('sizes.store');
        Route::put('/sizes/{size}', [SizeController::class, 'update'])->name('sizes.update');
        Route::delete('/sizes/{size}', [SizeController::class, 'destroy'])->name('sizes.destroy');
    });
});