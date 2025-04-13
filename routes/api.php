<?php

use App\Http\Controllers\API\Guru\JawabanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Guru\TesController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Guru\GuruController;
use App\Http\Controllers\API\Guru\SoalController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::prefix('/guru')->group(function() {
        Route::prefix('/tes')->group(function() {
            Route::post('/create', [TesController::class,'createTes']);
            Route::put('/update/{tes_id}', [TesController::class,'updateTes']);
            Route::get('/show', [TesController::class, 'showTes']);
            Route::get('/show/{tes_id}', [TesController::class, 'showTesById']);
            Route::put('/setstatus/{tes_id}', [TesController::class, 'setStatus']);
            Route::delete('/delete/{tes_id}', [TesController::class, 'deleteTes']);
            Route::delete('/deleteall', [TesController::class, 'deleteAllTes']);
        });

        Route::prefix('/soal')->group(function() {
            Route::post('/create/{tes_id}', [SoalController::class,'createSoal']);
            Route::get('/show/{tes_id}', [SoalController::class, 'showSoal']);
            Route::put('/update/{soal_id}', [SoalController::class, 'updateSoal']);
            Route::delete('/deleteall/{tes_id}', [SoalController::class, 'deleteAllSoal']);
            Route::delete('/delete/{soal_id}', [SoalController::class, 'deleteSoalById']);
        });

        Route::prefix('/jawaban')->group(function() {
            Route::post('/create/{soal_id}', [JawabanController::class,'createJawaban']);
            Route::put('/update/{jawaban_id}', [JawabanController::class,'updateJawaban']);
            Route::get('/show/{soal_id}', [JawabanController::class, 'seeAllJawabans']);
            Route::delete('/delete/{jawaban_id}', [JawabanController::class, 'deleteJawaban']);
        });

        Route::prefix('/misc')->group(function() {
            Route::get('/siswa', [GuruController::class, 'seeSiswa']);
            Route::get('/siswa/{class}', [GuruController::class, 'seeSiswaByClass']);
        });

        

    });
});
