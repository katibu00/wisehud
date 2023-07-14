<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MonnifyController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Auth;

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
        if(Auth::user()->user_type == 'admin'){
            return redirect()->route('admin.home');
        }
    }
   
    return view('welcome');
})->name('welcome');


Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::group(['middleware' => ['auth', 'regular']], function () {
    Route::get('/user/home', [HomeController::class, 'regular'])->name('regular.home');
});

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin/home', [AdminController::class, 'index'])->name('admin.home');
});




Route::post('/get-transfers',  [MonnifyController::class, 'getTransfers']);

Route::post('/webhook',  [MonnifyController::class, 'getTransfers']);


Route::post('/api/submit',  [ChatController::class, 'submit']);


Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');



Route::group(['prefix' => 'settings', 'middleware' => ['auth', 'admin']], function () {
   
    Route::get('/openai_key', [SettingsController::class, 'openaiKeys'])->name('openai_key');
    Route::post('/openai_key', [SettingsController::class, 'saveOpenai']);

    Route::get('/monnify_api_key', [SettingsController::class, 'monnifyKeys'])->name('monnify_api_key');
    Route::post('/monnify_api_key', [SettingsController::class, 'saveMonnify']);

    Route::get('/charges', [SettingsController::class, 'charges'])->name('charges');
    Route::post('/charges', [SettingsController::class, 'saveCharges']);

});

Route::group(['prefix' => 'users', 'middleware' => ['auth', 'admin']], function () {
   
    Route::get('/regular', [UsersController::class, 'regular'])->name('regular.index');
    Route::post('/manual-funding', [UsersController::class, 'manualFunding'])->name('manual-funding');

   

});
