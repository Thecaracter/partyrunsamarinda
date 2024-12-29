<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\RegistrasiController;


Route::view('/', 'user.landing')->name('home');
Route::prefix('registrasi')->name('registrasi.')->group(function () {
    Route::get('/', [RegistrasiController::class, 'index'])->name('index');
    Route::post('/step1', [RegistrasiController::class, 'saveStep1'])->name('step1');
    Route::post('/step2', [RegistrasiController::class, 'saveStep2'])->name('step2');
    Route::post('/step3', [RegistrasiController::class, 'saveStep3'])->name('step3');

    // API Wilayah routes
    Route::get('/provinces', [RegistrasiController::class, 'getProvinces']);
    Route::get('/cities/{province}', [RegistrasiController::class, 'getCities']);
    Route::get('/districts/{city}', [RegistrasiController::class, 'getDistricts']);
    Route::get('/villages/{district}', [RegistrasiController::class, 'getVillages']);
});
