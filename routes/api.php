<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
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
    Route::post('/logout', [LoginController::class, 'apiLogout']);
    Route::post('/submit_prompt',  [ChatController::class, 'submit']);

});

Route::get('/get-popup', [HomeController::class, 'getPopup']);

