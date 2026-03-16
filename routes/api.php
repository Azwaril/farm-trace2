<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LahanController;
use App\Http\Controllers\PenanamanController;
use App\Http\Controllers\TanamanController;
use App\Http\Controllers\VarietasController;
use App\Http\Controllers\PupukController;
use App\Http\Controllers\ArtikelController;

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::get('/artikel', [ArtikelController::class, 'index']);
Route::get('/artikel/{id}', [ArtikelController::class, 'show']);

Route::middleware(['auth:api','admin'])->group(function () {

    Route::post('/artikel',[ArtikelController::class,'store']);
    Route::put('/artikel/{id}',[ArtikelController::class,'update']);
    Route::delete('/artikel/{id}',[ArtikelController::class,'destroy']);

});

Route::middleware('auth:api')->group(function () {
    
    Route::get('/me',[AuthController::class,'me']);
    Route::post('/logout',[AuthController::class,'logout']);
    Route::apiResource('lahan',LahanController::class);
    Route::apiResource('tanaman',TanamanController::class);
    Route::apiResource('varietas',VarietasController::class);
    Route::apiResource('penanaman',PenanamanController::class);
    Route::apiResource('pupuk',PupukController::class);

});