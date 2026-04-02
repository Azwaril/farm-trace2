<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LahanController;
use App\Http\Controllers\PenanamanController;
use App\Http\Controllers\TanamanController;
use App\Http\Controllers\VarietasController;
use App\Http\Controllers\PupukController;
use App\Http\Controllers\RiwayatPupukController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\PanenController;

// ======================
// AUTH
// ======================

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);


// ======================
// SEMUA ROLE HARUS LOGIN
// ======================

Route::middleware('auth:api')->group(function () {

    Route::get('/me',[AuthController::class,'me']);
    Route::post('/logout',[AuthController::class,'logout']);

    // ======================
    // KONSUMEN
    // ======================
    Route::middleware('role:konsumen')->group(function () {

        Route::get('/beranda', function () {
            return response()->json([
                'message' => 'Selamat datang di Farm Trace'
            ]);
        });

        Route::get('/tentang-kami', function () {
            return response()->json([
                'message' => 'Website Farm Trace adalah sistem pelacakan hasil pertanian'
            ]);
        });

        Route::get('/artikel',[ArtikelController::class,'index']);
        Route::get('/artikel/{id}',[ArtikelController::class,'show']);
    });


    // ======================
    // ADMIN & PETANI
    // ======================
    Route::middleware('role:admin,petani')->group(function () {

        Route::apiResource('lahan',LahanController::class);
        Route::apiResource('tanaman',TanamanController::class);
        Route::apiResource('penanaman',PenanamanController::class);
        Route::apiResource('pupuk',PupukController::class);
        Route::apiResource('riwayat-pupuk',RiwayatPupukController::class);
        Route::apiResource('panen',PanenController::class);

        Route::get('/varietas',[VarietasController::class,'index']);
        Route::get('/varietas/{id}',[VarietasController::class,'show']);

        Route::get('/beranda',[ArtikelController::class,'index']);
    });


    // ======================
    // ADMIN SAJA
    // ======================
    Route::middleware('role:admin')->group(function () {

        Route::apiResource('varietas',VarietasController::class);

        Route::post('/artikel',[ArtikelController::class,'store']);
        Route::put('/artikel/{id}',[ArtikelController::class,'update']);
        Route::delete('/artikel/{id}',[ArtikelController::class,'destroy']);

        Route::get('/artikel',[ArtikelController::class,'index']);
        Route::get('/artikel/{id}',[ArtikelController::class,'show']);

        Route::get('/tentang-kami', function () {
            return response()->json([
                'message' => 'Website Farm Trace'
            ]);
        });
    });

});