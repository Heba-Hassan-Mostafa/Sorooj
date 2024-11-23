<?php

use App\Http\Controllers\Api\V1\Transaction\PaymentController;
use App\Http\Controllers\DashboardWeb\DashboardController;
use App\Http\Controllers\DashboardWeb\V1\AdminController;
use App\Http\Controllers\DashboardWeb\V1\AuthController;
use App\Http\Controllers\DashboardWeb\V1\Courses\CourseCategoryController;
use App\Http\Controllers\DashboardWeb\V1\Courses\CourseController;
use App\Http\Controllers\DashboardWeb\V1\RoleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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


// Authentication Routes
Route::group(['middleware'=>['guest'],'prefix' => 'admin', 'as' => 'admin.'], function () {
    //login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    //Forget Password
    Route::get('/forget-password', [AuthController::class, 'showForgetPasswordForm'])->name('forget.password');
    Route::post('/forget-password', [AuthController::class, 'forgetPassword'])->name('forget.password.submit');

    //OTP
    Route::get('/verify-otp', [AuthController::class, 'showVerifyOTPForm'])->name('verify.otp');
    Route::post('/verify-otp', [AuthController::class, 'verifyOTP'])->name('verify.otp.submit');
    Route::post('/resend-otp', [AuthController::class, 'resendOTP'])->name('resend.otp');

    //Reset Password
    Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('reset.password');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password.submit');

});
Route::group(['middleware'=>['auth'] ,'prefix' => 'admin', 'as' => 'admin.'], function () {


    Route::post('/password/change', [AuthController::class, 'changePassword'])->name('password.change');

    // OTP Routes
    Route::post('/otp/send', [AuthController::class, 'sendOTP'])->name('otp.send');

    // Profile (Protected with Middleware)
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile')->middleware('auth');
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // Account Deletion
    Route::post('/delete-account', [AuthController::class, 'deleteAccount'])->name('account.delete')->middleware('auth');

  });
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]

    ], function(){

    Route::group(['middleware'=>['auth'] ,'prefix' => 'admin', 'as' => 'admin.'], function () {

        Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

        # Roles
        Route::get('/roles/change-status',      [RoleController::class,'changeStatus'])->name('roles.change-status');
        Route::resource('/roles', RoleController::class);

        # admins
        Route::get('/admins/change-status',      [AdminController::class,'changeStatus'])->name('admins.change-status');
        Route::resource('/admins', AdminController::class);

        Route::group(['prefix' => 'courses', 'as' => 'courses.'], function () {

            Route::get('/category/change-status',      [CourseCategoryController::class,'changeStatus'])->name('category.change-status');
            Route::resource('/category', CourseCategoryController::class);

            Route::get('/courses/change-status',      [CourseController::class,'changeStatus'])->name('courses.change-status');
            Route::resource('/courses', CourseController::class);

        });
    });
});
