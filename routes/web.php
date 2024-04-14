<?php

use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MonnifyController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\WalletControler;
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

Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.forgot');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.send.reset.link');

Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

Route::group(['middleware' => ['auth', 'regular']], function () {
    Route::get('/user/home', [HomeController::class, 'regular'])->name('regular.home');
});

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin/home', [HomeController::class, 'admin'])->name('admin.home');
});




Route::post('/get-transfers',  [MonnifyController::class, 'getTransfers']);

Route::post('/webhook',  [MonnifyController::class, 'getTransfers']);


Route::post('/api/submit',  [ChatController::class, 'submit'])->middleware('auth');


Route::get('/chat', [ChatController::class, 'index'])->name('chat.index')->middleware('auth');
Route::get('/wallet', [WalletControler::class, 'index'])->name('wallet.index')->middleware('auth');

Route::get('/chat-history', [ChatController::class, 'chatHistory'])->name('chat.history');
Route::get('/chat/{sessionId}', [ChatController::class, 'chatDetails'])->name('chat.details');





Route::group(['prefix' => 'settings', 'middleware' => ['auth', 'admin']], function () {
   
    Route::get('/openai_key', [SettingsController::class, 'openaiKeys'])->name('openai_key');
    Route::post('/openai_key', [SettingsController::class, 'saveOpenai']);

    Route::get('/monnify_api_key', [SettingsController::class, 'monnifyKeys'])->name('monnify_api_key');
    Route::post('/monnify_api_key', [SettingsController::class, 'saveMonnify']);

    Route::get('/charges', [SettingsController::class, 'charges'])->name('charges');
    Route::post('/charges', [SettingsController::class, 'saveCharges']);


    Route::get('/pop_up_notification', [SettingsController::class, 'popup'])->name('pop_up_notification');
    Route::post('/pop_up_notification', [SettingsController::class, 'savePopup']);


    Route::get('/brevo_key', [SettingsController::class, 'brevoKeys'])->name('brevo_key');
    Route::post('/brevo_key', [SettingsController::class, 'saveBrevo']);

    Route::get('/paystack_key', [SettingsController::class, 'paystackKeys'])->name('paystack_key');
    Route::post('/paystack_key', [SettingsController::class, 'savePaystack']);


    Route::get('/marquee_notification', [SettingsController::class, 'marquee'])->name('marquee_notification');
    Route::post('/marquee_notification', [SettingsController::class, 'saveMarquee'])->name('marquee_notification.save');


});

Route::group(['prefix' => 'users', 'middleware' => ['auth', 'admin']], function () {
   
    Route::get('/regular', [UsersController::class, 'regular'])->name('regular.index');
    Route::get('/admins', [UsersController::class, 'admins'])->name('admins.index');
    Route::post('/manual-funding', [UsersController::class, 'manualFunding'])->name('manual-funding');
    Route::post('/change-password', [UsersController::class, 'changePassword'])->name('change-password');
    Route::delete('/{id}',  [UsersController::class, 'destroy'])->name('users.destroy');

    Route::post('/admin/submit',  [UsersController::class, 'storeAdmin'])->name('admin.store');

    Route::get('/search-users', [UsersController::class, 'search'])->name('search-users');



});


