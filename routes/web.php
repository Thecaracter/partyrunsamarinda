<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\User\BibController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\CheckOrderController;
use App\Http\Controllers\User\RegistrasiController;

// Landing Page
Route::view('/', 'user.landing')->name('home');
Route::get('/about', function () {
    return view('user.about-us');
})->name('about');
Route::get('/event', function () {
    return view('user.event');
})->name('event');
Route::get('/rules', function () {
    return view('user.rules');
})->name('rules');
// Registrasi Routes
Route::prefix('registrasi')->group(function () {
    // Route::get('/', [RegistrasiController::class, 'index'])->name('registrasi.index');

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
    // Public Auth Routes (Login)
    Route::middleware(['guest'])->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
    });

    // Protected Admin Routes - All routes require authentication
    Route::middleware(['auth'])->group(function () {
        // Logout Route
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Size Management Routes
        Route::prefix('sizes')->as('sizes.')->group(function () {
            Route::get('/', [SizeController::class, 'index'])->name('index');
            Route::post('/', [SizeController::class, 'store'])->name('store');
            Route::put('/{size}', [SizeController::class, 'update'])->name('update');
            Route::delete('/{size}', [SizeController::class, 'destroy'])->name('destroy');
        });

        // Peserta Management Routes
        Route::prefix('peserta')->as('peserta.')->group(function () {
            Route::get('/', [PesertaController::class, 'index'])->name('index');
            Route::get('/scan', [PesertaController::class, 'index'])->name('scan-page');
            Route::get('/data', [PesertaController::class, 'getPesertaData'])->name('data');
            Route::get('/{bibNumber}', [PesertaController::class, 'getPeserta'])->name('get');
            Route::post('/scan', [PesertaController::class, 'scanBib'])->name('scan');
        });

        // Export Route
        Route::get('/export-excel', [AdminController::class, 'exportExcel'])->name('export.excel');
    });
});
// Tambahkan use statement
Route::prefix('admin/email')->as('admin.email.')->group(function () {
    Route::get('/', [EmailController::class, 'showEmailDashboard'])->name('index');
    Route::post('/send-single', [EmailController::class, 'sendSingleEmail'])->name('send-single');
    Route::get('/blast', [EmailController::class, 'blastEmails'])->name('blast');
});