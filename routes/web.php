<?php

use App\Http\Controllers\BuyDataController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DataPlansController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MonnifyController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
   
    if(auth()->check()){
        if(Auth::user()->user_type == 'regular'){
            return redirect()->route('regular.home');
        }
        if(Auth::user()->user_type == 'regular'){
            return redirect()->route('regular.home');
        }
    }
   
    return view('auth.login');
});


Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::group(['middleware' => ['auth', 'regular']], function () {
    Route::get('/user/home', [HomeController::class, 'regular'])->name('regular.home');
});
Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin/home', [HomeController::class, 'admin'])->name('admin.home');
});


Route::post('/get-transfers',  [MonnifyController::class, 'getTransfers']);

Route::post('/webhook',  [MonnifyController::class, 'getTransfers']);


Route::post('/api/submit',  [ChatController::class, 'submit']);