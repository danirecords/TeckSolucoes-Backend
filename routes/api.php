<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ProcessingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['jwt.auth'])->group(function () {

    Route::middleware(['role:admin'])->group(function () {
        Route::post('/users', [UserController::class, 'store']);
        Route::get('/users', [UserController::class, 'index']);
    });


    Route::post('/import', [ImportController::class, 'import']);
    Route::get('/import/{id}', [ImportController::class, 'show']);

    Route::get('/processings', [ProcessingController::class, 'index']);
    Route::get('/processings/{id}', [ProcessingController::class, 'show']);

    Route::get('/processings/{id}/download/excel', [ProcessingController::class, 'downloadExcel']);
    Route::get('/processings/{id}/download/cnab', [ProcessingController::class, 'downloadCnab']);
});
