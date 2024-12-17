<?php

use App\Http\Controllers\DashboardWeb\DashboardController;
use App\Http\Controllers\DashboardWeb\V1\AdminController;
use App\Http\Controllers\DashboardWeb\V1\AuthController;
use App\Http\Controllers\DashboardWeb\V1\Blogs\BlogCategoryController;
use App\Http\Controllers\DashboardWeb\V1\Blogs\BlogController;
use App\Http\Controllers\DashboardWeb\V1\Books\BookCategoryController;
use App\Http\Controllers\DashboardWeb\V1\Books\BookController;
use App\Http\Controllers\DashboardWeb\V1\Courses\CourseCategoryController;
use App\Http\Controllers\DashboardWeb\V1\Courses\CourseController;
use App\Http\Controllers\DashboardWeb\V1\HomeSections\UpcomingEventController;
use App\Http\Controllers\DashboardWeb\V1\RoleController;
use App\Http\Controllers\DashboardWeb\V1\HomeSections\SliderController;
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

        // Courses
        Route::group(['prefix' => 'courses', 'as' => 'courses.'], function () {

            Route::get('/category/change-status',      [CourseCategoryController::class,'changeStatus'])->name('category.change-status');
            Route::get('/category/sort-categories', [CourseCategoryController::class,'livewire_index'])->name('category.sort-categories');

            Route::resource('/category', CourseCategoryController::class);

            Route::get('/courses/change-status',      [CourseController::class,'changeStatus'])->name('courses.change-status');
            Route::get('/sort-courses', [CourseController::class,'livewire_index'])->name('sort-courses');
            Route::get('/videos/sort/{course}', [CourseController::class,'videosSort'])->name('videos.sort');

            Route::resource('/courses', CourseController::class);

            //delete attachments
            Route::delete('/courses/{course}/attachments/{attachment}', [CourseController::class, 'deleteCourseAttachment'])
                ->name('courses.deleteAttachment');
            //delete image
            Route::delete('/courses/{course}/image', [CourseController::class, 'deleteCourseImage'])
                ->name('courses.deleteCourseImage');

        });

        // Books
        Route::group(['prefix' => 'books', 'as' => 'books.'], function () {

            Route::get('/category/change-status',      [BookCategoryController::class,'changeStatus'])->name('category.change-status');
            Route::get('/category/sort-categories', [BookCategoryController::class,'livewire_index'])->name('category.sort-categories');

            Route::resource('/category', BookCategoryController::class);

            Route::get('/books/change-status',      [BookController::class,'changeStatus'])->name('books.change-status');
            Route::get('/sort-books', [BookController::class,'livewire_index'])->name('sort-books');
            Route::get('/videos/sort/{book}', [BookController::class,'videosSort'])->name('videos.sort');

            Route::resource('/books', BookController::class);

            //delete attachments
            Route::delete('/books/{book}/attachments/{attachment}', [BookController::class, 'deleteBookAttachment'])
                ->name('books.deleteAttachment');
            //delete image
            Route::delete('/books/{book}/image', [BookController::class, 'deleteBookImage'])
                ->name('books.deleteBookImage');

        });

        // Blogs
        Route::group(['prefix' => 'blogs', 'as' => 'blogs.'], function () {

            Route::get('/category/change-status',      [BlogCategoryController::class,'changeStatus'])->name('category.change-status');
            Route::get('/category/sort-categories', [BlogCategoryController::class,'livewire_index'])->name('category.sort-categories');

            Route::resource('/category', BlogCategoryController::class);

            Route::get('/blogs/change-status',      [BlogController::class,'changeStatus'])->name('blogs.change-status');
            Route::get('/sort-blogs', [BlogController::class,'livewire_index'])->name('sort-blogs');
            Route::get('/videos/sort/{blog}', [BlogController::class,'videosSort'])->name('videos.sort');

            Route::resource('/blogs', BlogController::class);

            //delete attachments
            Route::delete('/blogs/{blog}/attachments/{attachment}', [BlogController::class, 'deleteBlogAttachment'])
                ->name('blogs.deleteAttachment');
            //delete image
            Route::delete('/blogs/{blog}/image', [BlogController::class, 'deleteBlogImage'])
                ->name('blogs.deleteBlogImage');
            //delete video
            Route::delete('/blogs/{blog}/video', [BlogController::class, 'deleteBlogVideo'])
                ->name('blogs.deleteBlogVideo');
        });


        // Slider
        Route::group(['prefix' => 'slider', 'as' => 'slider.'], function () {

            Route::get('/change-status',      [SliderController::class,'changeStatus'])->name('change-status');
            Route::get('/sort-slider', [SliderController::class,'livewire_index'])->name('sort-slider');

            Route::resource('/slider', SliderController::class);


        });

        // Events
        Route::group(['prefix' => 'events', 'as' => 'events.'], function () {

            Route::get('/upcoming-events/change-status',      [UpcomingEventController::class,'changeStatus'])
                ->name('upcoming-events.change-status');
            Route::get('/past-events',      [UpcomingEventController::class,'pastEvents'])
                ->name('past-events');
            Route::resource('/upcoming-events', UpcomingEventController::class);


        });
    });
});
