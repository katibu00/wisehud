<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\WalletControler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [RegisterController::class,'register']);
Route::post('/login', [LoginController::class,'apiLogin']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/wallet/balance', [WalletControler::class, 'getWalletBalance']);
});
