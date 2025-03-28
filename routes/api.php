<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Guru\TesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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
        Route::post('/createtes', [TesController::class,'createTes']);
        Route::put('/updatetes/{tes_id}', [TesController::class,'updateTes']);
        Route::get('/showtes', [TesController::class, 'showTes']);
        Route::get('/showtes/{tes_id}', [TesController::class, 'showTesById']);
        Route::put('/setstatus/{tes_id}', [TesController::class, 'setStatus']);
        Route::delete('/deletetes/{tes_id}', [TesController::class, 'deleteTes']);
        Route::delete('/deletealltes', [TesController::class, 'deleteAllTes']);
    });
});