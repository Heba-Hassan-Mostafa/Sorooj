<?php

use App\Http\Controllers\Api\V1\Client\AuthController;
use App\Http\Controllers\Api\V1\Client\Books\BookCategoryController;
use App\Http\Controllers\Api\V1\Client\Books\BookController;
use App\Http\Controllers\Api\V1\Client\Courses\CategoryController;
use App\Http\Controllers\Api\V1\Client\Courses\CourseController;
use Illuminate\Support\Facades\Route;

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
    Route::middleware(["auth:sanctum"])->group(function () {
        Route::post('resend-otp', [AuthController::class, 'resendOTP']);
        Route::post('verify-otp', [AuthController::class, 'verifyOTP']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('can-change-mobile', [AuthController::class, 'canChangeMobile']);
        Route::post('change-mobile', [AuthController::class, 'changeMobile']);
        Route::post('change-password', [AuthController::class, 'changePassword']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
        Route::post('update-profile', [AuthController::class, 'updateProfile']);
        Route::delete('delete-account', [AuthController::class, 'deleteAccount']);
    });
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('forget-password', [AuthController::class, 'forgetPassword']);
    Route::post('validate-mobile-email', [AuthController::class, 'validateMobileorEmail']);
    Route::post('send-otp', [AuthController::class, 'sendOTP']);
});

        //courses
        Route::group(['prefix' => 'courses', 'as' => 'courses.'], function () {

            //categories
            Route::get('categories', [CategoryController::class, 'index'])->name('category.index');
            //index
            Route::get('/', [CourseController::class, 'index'])->name('courses.index');
            //suggested
            Route::get('/suggested-courses', [CourseController::class, 'suggestedCourses'])->name('suggested-courses');

            //show
            Route::get('/{slug}', [CourseController::class, 'show'])->name('courses.show');

            //comments
            Route::post('/add-comment/{courseId}', [CourseController::class, 'addComment'])
                ->name('add-comment')->middleware('auth:sanctum');
            //favorite
            Route::post('/toggle-favorite/{courseId}', [CourseController::class, 'toggleFavorite'])
                ->name('toggle-favorite')->middleware('auth:sanctum');
            //subscription
            Route::post('/add-subscription/{courseId}', [CourseController::class, 'addSubscription'])
                ->name('add-subscription')->middleware('auth:sanctum');

        });



        //books
        Route::group(['prefix' => 'books', 'as' => 'books.'], function () {

            //categories
            Route::get('categories', [BookCategoryController::class, 'index'])->name('category.index');
            //index
            Route::get('/', [BookController::class, 'index'])->name('index');
            //suggested
            Route::get('/suggested-books', [BookController::class, 'suggestedBooks'])->name('suggested-books');
            //show
            Route::get('/{slug}', [BookController::class, 'show'])->name('show');

            //comments
            Route::post('/add-comment/{courseId}', [BookController::class, 'addComment'])
                ->name('add-comment')->middleware('auth:sanctum');
            //favorite
            Route::post('toggle-favorite/{courseId}', [BookController::class, 'toggleFavorite'])
                ->name('toggle-favorite')->middleware('auth:sanctum');



        });


Route::middleware(["auth:api"])->group(function () {

//
});
