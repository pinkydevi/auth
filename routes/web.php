<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// web Routes API
Route::post('/user-registration',[UserController::class,'UserRegistration']);
Route::post('/user-login',[UserController::class,'UserLogin']);
Route::post('/send-otp',[UserController::class,'SendOTPCode']);
Route::post('/verify-otp',[UserController::class,'VerifyOTP']);

// token Verify
Route::post('/reset-pass',[UserController::class,'ResetPass'])
 ->middleware([TokenVerificationMiddleware::class]);

//Page Routes

// Route::get('/user-registration',[UserController::class,'RegistrationPage']);
// Route::get('/user-login',[UserController::class,'LoginPage']);
// Route::get('/send-otp',[UserController::class,'SendOTPCodePage']);
// Route::get('/verify-otp',[UserController::class,'VerifyOTPPage']);
// Route::get('/reset-pass',[UserController::class,'ResetPassPage'])
// ->middleware([TokenVerificationMiddleware::class]);
// Route::get('/dashboard',[UserController::class,'DashboardPage']);


Route::view('/','pages.home');
Route::view('/user-login','pages.auth.login-page')->name('login');
Route::view('/user-registration','pages.auth.registration-page');
Route::view('/send-otp','pages.auth.send-otp-page');
Route::view('/verify-otp','pages.auth.verify-otp-page');
Route::view('/reset-pass','pages.auth.reset-pass-page');
Route::view('/userProfile','pages.dashboard.profile-page');


