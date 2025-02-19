<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Dashboard\{PermissionController, RoleController, AuthController, SettingController, UserController};
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix("auth")->group(function () {
    Route::middleware(["auth:api"])->group(function () {
        Route::post('resend-otp', [AuthController::class, 'resendOTP']);
        Route::post('verify-otp', [AuthController::class, 'verifyOTP']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('changpassword', [AuthController::class, 'changePassword']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
        Route::delete('delete-account', [AuthController::class, 'deleteAccount']);
    });
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forget-password', [AuthController::class, 'forgetPassword']);
    Route::post('send-otp', [AuthController::class, 'sendOTP']);
});


Route::middleware(["auth:api"])->group(function () {
    # Roles
    Route::apiResource('roles', RoleController::class);

    # Permission
    Route::get('permissions', PermissionController::class);

    # Setting
    Route::apiResource('settings', SettingController::class);

    # Users
    Route::apiResource('users', UserController::class);

    # Chat
    include __DIR__ . '/chat.php';

    # Notification
    include __DIR__ . '/notification.php';
});
