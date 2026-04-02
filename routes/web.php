<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthWebController;

Route::get('/register', [AuthWebController::class, 'register']);
Route::post('/register', [AuthWebController::class, 'registerPost']);
Route::get('/login', [AuthWebController::class, 'login']);
Route::post('/login', [AuthWebController::class, 'loginPost']);